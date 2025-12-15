# Getecz Laravel Installer by Ajith Joseph

A lightweight installer wizard package for **Laravel 12** applications.

## Features
- Laravel 12 compatible
- Tailwind CDN installer UI (no build tools required)
- Server requirements check
- Database connection validation
- Writes `.env` from installer input
- Generates `APP_KEY`
- Runs migrations safely
- Creates admin user
- Locks installer after completion

## Requirements
- PHP 8.1+
- Laravel 12
- MySQL 5.7+ / MariaDB
- Writable: `storage/` and `bootstrap/cache/`

## Install

### 1) Require the package
```bash
composer require getecz/laravel-installer
```

### 2) (Optional) Publish config / views
```bash
php artisan vendor:publish --tag=installer-config
php artisan vendor:publish --tag=installer-views
```

### 3) Enable automatic redirect to installer (Laravel 12)
In **bootstrap/app.php** add the middleware to the `web` group:

```php
use Getecz\Installer\Http\Middleware\RedirectIfNotInstalled;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->appendToGroup('web', RedirectIfNotInstalled::class);
    })
    ->create();
```

> If you don't want auto-redirect, skip this step and manually visit `/install`.

## Usage
1. Upload your Laravel project to your server.
2. Visit your site in a browser.
3. If the app is not installed, you will be redirected to `/install`.
4. Complete the steps.
5. After installation, the installer locks automatically using the installed file:
   - `storage/installed`

## Configuration
Publish config (optional) and edit `config/installer.php`.

### Change post-install redirect
```php
'redirect_after_install' => '/login'
```

### Change user model
```php
'user_model' => \App\Models\User::class
```

### Map admin fields
If your users table has custom columns:
```php
'admin_fields' => [
  'name' => 'full_name',
  'email' => 'email',
  'password' => 'password',
],
'admin_defaults' => [
  'is_admin' => 1,
  'role' => 'admin',
],
```

## Security
- Installer routes are blocked once the installed lock file exists.
- Delete `storage/installed` to re-run the installer.

## Routes
- `/install`
- `/install/requirements`
- `/install/database`
- `/install/run`
- `/install/admin`
- `/install/finish`

## License
MIT
