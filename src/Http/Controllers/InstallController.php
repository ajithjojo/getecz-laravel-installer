<?php

namespace Getecz\Installer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InstallController extends Controller
{
    public function welcome()
    {
        return view('getecz-installer::welcome');
    }

    public function requirements()
    {
        $checks = [
            'php >= 8.1'               => version_compare(PHP_VERSION, '8.1.0', '>='),
            'pdo_mysql extension'      => extension_loaded('pdo_mysql'),
            'mbstring extension'       => extension_loaded('mbstring'),
            'openssl extension'        => extension_loaded('openssl'),
            'tokenizer extension'      => extension_loaded('tokenizer'),
            'json extension'           => extension_loaded('json'),
            'curl extension'           => extension_loaded('curl'),
            'storage writable'         => is_writable(storage_path()),
            'bootstrap/cache writable' => is_writable(base_path('bootstrap/cache')),
        ];

        return view('getecz-installer::requirements', compact('checks'));
    }

    public function databaseForm()
    {
        return view('getecz-installer::database');
    }

    public function saveDatabase(Request $request)
    {
        $data = $request->validate([
            'app_url' => 'required|url',
            'db_host' => 'required|string',
            'db_port' => 'required|numeric',
            'db_name' => 'required|string',
            'db_user' => 'required|string',
            'db_pass' => 'nullable|string',
        ]);

        $this->testDb($data);

        $pairs = [
            'APP_URL'     => $data['app_url'],
            'DB_HOST'     => $data['db_host'],
            'DB_PORT'     => $data['db_port'],
            'DB_DATABASE' => $data['db_name'],
            'DB_USERNAME' => $data['db_user'],
            'DB_PASSWORD' => $data['db_pass'] ?? '',
        ];

        // Force safe drivers during install (prevents "cache table not found" crashes)
        foreach ((array) config('installer.safe_env', []) as $k => $v) {
            $pairs[$k] = $v;
        }

        $this->writeEnv($pairs);

        // Make sure the app reloads the new .env
        Artisan::call('config:clear');

        // Generate app key
        Artisan::call('key:generate', ['--force' => true]);

        return redirect()->route('installer.run');
    }

    public function run()
    {
        Artisan::call('config:clear');

        // Run migrations first. Do NOT run cache:clear during install.
        Artisan::call('migrate', ['--force' => true]);

        // Optional: seed (uncomment if your app needs default data)
        // Artisan::call('db:seed', ['--force' => true]);

        // Storage link is commonly needed for uploaded assets
        Artisan::call('storage:link');

        // Clear compiled views/routes for fresh install state
        Artisan::call('route:clear');
        Artisan::call('view:clear');

        return redirect()->route('installer.admin');
    }

    public function adminForm()
    {
        return view('getecz-installer::admin');
    }

    public function createAdmin(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:120',
            'email'    => 'required|email|max:190',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $userModel = config('installer.user_model');
        $fields    = config('installer.admin_fields', []);
        $defaults  = config('installer.admin_defaults', []);

        if (!class_exists($userModel)) {
            abort(500, 'Installer config error: user_model class not found.');
        }

        $payload = array_merge($defaults, [
            $fields['name']     ?? 'name'     => $data['name'],
            $fields['email']    ?? 'email'    => $data['email'],
            $fields['password'] ?? 'password' => Hash::make($data['password']),
        ]);

        // Use email as unique key
        $emailColumn = $fields['email'] ?? 'email';

        $user = $userModel::updateOrCreate(
            [$emailColumn => $data['email']],
            $payload
        );

        // Lock installer
        @file_put_contents(config('installer.installed_file'), now()->toDateTimeString());

        return redirect()->route('installer.finish');
    }

    public function finish()
    {
        $redirect = config('installer.redirect_after_install', '/login');
        return view('getecz-installer::finish', compact('redirect'));
    }

    private function testDb(array $data): void
    {
        config([
            'database.connections.__installer' => [
                'driver' => 'mysql',
                'host' => $data['db_host'],
                'port' => $data['db_port'],
                'database' => $data['db_name'],
                'username' => $data['db_user'],
                'password' => $data['db_pass'] ?? '',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'strict' => true,
            ],
        ]);

        DB::purge('__installer');

        try {
            DB::connection('__installer')->select('SELECT 1');
        } catch (\Throwable $e) {
            abort(422, 'Database connection failed: ' . $e->getMessage());
        }
    }

    private function writeEnv(array $pairs): void
    {
        $envPath = base_path('.env');

        if (!file_exists($envPath)) {
            if (file_exists(base_path('.env.example'))) {
                copy(base_path('.env.example'), $envPath);
            } else {
                file_put_contents($envPath, '');
            }
        }

        $env = file_get_contents($envPath);

        foreach ($pairs as $key => $value) {
            $value = $this->escapeEnvValue($value);

            if (preg_match("/^{$key}=.*/m", $env)) {
                $env = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $env);
            } else {
                $env .= PHP_EOL . "{$key}={$value}";
            }
        }

        file_put_contents($envPath, $env);
    }

    private function escapeEnvValue($value): string
    {
        $value = (string) $value;

        // Quote values containing spaces or special chars
        if (preg_match('/\s|#|=|"/', $value)) {
            $value = '"' . str_replace('"', '\\"', $value) . '"';
        }

        return $value;
    }
}
