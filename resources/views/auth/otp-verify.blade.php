@extends('layouts.guest')

@section('title', 'Verify OTP')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Verify OTP</h2>
        <p class="mt-2 text-sm text-gray-600">Enter the 6-digit code sent to {{ $identifier }}</p>
    </div>

    <form action="{{ route('auth.otp.verify.post') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="identifier" value="{{ $identifier }}">
        <input type="hidden" name="type" value="{{ $type }}">

        <div>
            <label for="code" class="block text-sm font-medium text-gray-700">
                OTP Code
            </label>
            <input type="text"
                name="code"
                id="code"
                required
                maxlength="6"
                pattern="[0-9]{6}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 px-4 py-2 border text-center text-2xl tracking-widest"
                placeholder="000000"
                autofocus>
            @error('code')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Verify & Login
            </button>
        </div>
    </form>

    <div class="text-center">
        <form action="{{ route('auth.otp.send') }}" method="POST" class="inline">
            @csrf
            <input type="hidden" name="identifier" value="{{ $identifier }}">
            <input type="hidden" name="type" value="{{ $type }}">
            <button type="submit" class="text-sm text-primary-600 hover:text-primary-500">
                Didn't receive code? Resend OTP
            </button>
        </form>
    </div>
</div>
@endsection