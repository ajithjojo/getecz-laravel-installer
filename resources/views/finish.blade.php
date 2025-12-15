@extends('getecz-installer::layout', [
    'title' => 'Installed',
    'heading' => 'Installation Complete 🎉',
    'subheading' => 'Your application is ready to use.'
])

@section('content')
    <div class="space-y-6 text-center">
        <p class="text-gray-600">
            The installer is now locked for security.
        </p>

        <a href="{{ $redirect }}"
           class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Continue
        </a>

        <p class="text-xs text-gray-400">
            If you need to re-run the installer, delete the installed lock file:
            <span class="font-mono">{{ config('installer.installed_file') }}</span>
        </p>
    </div>
@endsection
