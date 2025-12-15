@extends('getecz-installer::layout', [
    'title' => 'Database Setup',
    'heading' => 'Database Configuration',
    'subheading' => 'Enter your application URL and database credentials.'
])

@section('content')
    <form method="POST" action="{{ route('installer.database.save') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700">App URL</label>
            <input name="app_url" value="{{ old('app_url', url('/')) }}" required
                   class="w-full mt-1 border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200">
            <p class="text-xs text-gray-500 mt-1">Example: https://your-domain.com</p>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">DB Host</label>
                <input name="db_host" value="{{ old('db_host', '127.0.0.1') }}" required
                       class="w-full mt-1 border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">DB Port</label>
                <input name="db_port" value="{{ old('db_port', '3306') }}" required
                       class="w-full mt-1 border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Database Name</label>
            <input name="db_name" value="{{ old('db_name') }}" required
                   class="w-full mt-1 border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">DB Username</label>
                <input name="db_user" value="{{ old('db_user') }}" required
                       class="w-full mt-1 border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">DB Password</label>
                <input name="db_pass" type="password" value="{{ old('db_pass') }}"
                       class="w-full mt-1 border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200">
            </div>
        </div>

        <div class="flex items-center justify-between pt-2">
            <a href="{{ route('installer.requirements') }}"
               class="px-5 py-2 border rounded-lg hover:bg-gray-50">
                ← Back
            </a>
            <button class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Save & Continue →
            </button>
        </div>

        <div class="text-xs text-gray-400">
            Step 3 of 4
        </div>
    </form>
@endsection
