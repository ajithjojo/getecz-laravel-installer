@extends('getecz-installer::layout', [
    'title' => 'Requirements',
    'heading' => 'Server Requirements',
    'subheading' => 'Everything should be green before you continue.'
])

@section('content')
    <div class="space-y-5">
        <div class="text-sm text-gray-600">
            If something is missing, fix it on your server and refresh this page.
        </div>

        <ul class="divide-y rounded-lg border">
            @foreach ($checks as $name => $status)
                <li class="flex items-center justify-between p-3">
                    <span class="text-sm text-gray-700">{{ $name }}</span>
                    @if ($status)
                        <span class="text-green-600 font-semibold text-sm">✔ OK</span>
                    @else
                        <span class="text-red-600 font-semibold text-sm">✖ Missing</span>
                    @endif
                </li>
            @endforeach
        </ul>

        <div class="flex items-center justify-between pt-2">
            <a href="{{ route('installer.welcome') }}"
               class="px-5 py-2 border rounded-lg hover:bg-gray-50">
                ← Back
            </a>

            @if (!in_array(false, $checks, true))
                <a href="{{ route('installer.database') }}"
                   class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Continue →
                </a>
            @else
                <button disabled
                        class="px-6 py-2 bg-gray-300 text-gray-600 rounded-lg cursor-not-allowed">
                    Fix requirements to continue
                </button>
            @endif
        </div>

        <div class="text-xs text-gray-400">
            Step 2 of 4
        </div>
    </div>
@endsection
