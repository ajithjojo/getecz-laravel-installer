@extends('getecz-installer::layout', [
    'title' => 'Welcome',
    'heading' => 'Welcome',
    'subheading' => 'This wizard will guide you through the installation.'
])

@section('content')
    <div class="space-y-6">
        <div class="bg-blue-50 border border-blue-200 text-blue-900 p-4 rounded-lg text-sm">
            Make sure your server meets the minimum requirements before continuing.
        </div>

        <div class="flex items-center justify-between">
            <span class="text-sm text-gray-500">Step 1 of 4</span>
            <a href="{{ route('installer.requirements') }}"
               class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Start →
            </a>
        </div>
    </div>
@endsection
