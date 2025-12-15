@extends('getecz-installer::layout', [
    'title' => 'Create Admin',
    'heading' => 'Create Admin Account',
    'subheading' => 'Set up your primary login credentials.'
])

@section('content')
    <div class="mb-5 bg-green-50 border border-green-200 text-green-900 p-4 rounded-lg text-sm">
        Database is configured and migrations have been executed successfully.
    </div>

    <form method="POST" action="{{ route('installer.admin.create') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700">Name</label>
            <input name="name" value="{{ old('name') }}" required
                   class="w-full mt-1 border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-200">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input name="email" type="email" value="{{ old('email') }}" required
                   class="w-full mt-1 border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-200">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Password</label>
            <input name="password" type="password" required
                   class="w-full mt-1 border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-200">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input name="password_confirmation" type="password" required
                   class="w-full mt-1 border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-200">
        </div>

        <div class="flex items-center justify-between pt-2">
            <a href="{{ route('installer.database') }}"
               class="px-5 py-2 border rounded-lg hover:bg-gray-50">
                ← Back
            </a>
            <button class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Finish Installation →
            </button>
        </div>

        <div class="text-xs text-gray-400">
            Step 4 of 4
        </div>
    </form>
@endsection
