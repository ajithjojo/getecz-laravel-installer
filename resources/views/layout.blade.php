<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Installer' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-2xl bg-white shadow-lg rounded-2xl p-8">
        <div class="flex items-start justify-between gap-3 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $heading ?? 'Installer' }}</h1>
                @if(!empty($subheading))
                    <p class="text-sm text-gray-500 mt-1">{{ $subheading }}</p>
                @endif
            </div>
            <div class="text-xs text-gray-400 text-right leading-tight">
                <div class="font-semibold text-gray-500">Getecz</div>
                <div>Laravel Installer</div>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-5 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                <div class="font-semibold mb-1">Please fix the following:</div>
                <ul class="list-disc ml-5 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>
