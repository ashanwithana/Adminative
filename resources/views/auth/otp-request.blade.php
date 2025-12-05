@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Login to your account</h2>
        <p class="mt-2 text-sm text-gray-600">Enter your email or phone number to receive an OTP</p>
    </div>

    <form action="{{ route('auth.otp.send') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="type" value="login">

        <div>
            <label for="identifier" class="block text-sm font-medium text-gray-700">
                Email or Phone Number
            </label>
            <input type="text"
                name="identifier"
                id="identifier"
                required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 px-4 py-2 border"
                placeholder="email@example.com or +1234567890">
            @error('identifier')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Send OTP
            </button>
        </div>
    </form>

    <div class="text-center">
        <a href="{{ route('auth.register') }}" class="text-sm text-primary-600 hover:text-primary-500">
            Don't have an account? Register
        </a>
    </div>
</div>
@endsection