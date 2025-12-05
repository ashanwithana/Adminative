<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\LoginWithOtpAction;
use App\Actions\Auth\RegisterWithOtpAction;
use App\Actions\Auth\SendOtpAction;
use App\DTOs\OtpDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\SendOtpRequest;
use App\Http\Requests\Auth\VerifyOtpRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class OtpAuthController extends Controller
{
    public function __construct(
        private readonly SendOtpAction $sendOtpAction,
        private readonly LoginWithOtpAction $loginAction,
        private readonly RegisterWithOtpAction $registerAction
    ) {}

    /**
     * Show OTP request form
     */
    public function showRequestForm(): View
    {
        return view('auth.otp-request');
    }

    /**
     * Send OTP to user
     */
    public function sendOtp(SendOtpRequest $request): RedirectResponse
    {
        $key = 'send-otp:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('error', "Too many attempts. Please try again in {$seconds} seconds.");
        }

        RateLimiter::hit($key, 60);

        $dto = OtpDTO::fromRequest([
            'identifier' => $request->input('identifier'),
            'type' => $request->input('type'),
            'channel' => $request->input('channel'),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $result = $this->sendOtpAction->execute($dto);

        if (!$result['success']) {
            return back()->with('error', $result['message']);
        }

        return redirect()->route('auth.otp.verify', [
            'identifier' => $request->input('identifier'),
            'type' => $request->input('type'),
        ])->with('success', $result['message']);
    }

    /**
     * Show OTP verification form
     */
    public function showVerifyForm(Request $request): View
    {
        return view('auth.otp-verify', [
            'identifier' => $request->query('identifier'),
            'type' => $request->query('type', 'login'),
        ]);
    }

    /**
     * Verify OTP and login
     */
    public function verifyOtp(VerifyOtpRequest $request): RedirectResponse
    {
        $key = 'verify-otp:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('error', "Too many attempts. Please try again in {$seconds} seconds.");
        }

        RateLimiter::hit($key, 60);

        $result = $this->loginAction->execute(
            $request->input('identifier'),
            $request->input('code')
        );

        if (!$result['success']) {
            return back()->with('error', $result['message']);
        }

        $request->session()->put('otp_verified', true);

        return redirect()->intended(route('admin.dashboard'))
            ->with('success', $result['message']);
    }

    /**
     * Show registration form
     */
    public function showRegisterForm(Request $request): View
    {
        return view('auth.register', [
            'identifier' => $request->query('identifier'),
        ]);
    }

    /**
     * Register new user with OTP
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        $result = $this->registerAction->execute(
            $request->validated(),
            $request->input('code')
        );

        if (!$result['success']) {
            return back()->with('error', $result['message']);
        }

        $request->session()->put('otp_verified', true);

        return redirect()->route('admin.dashboard')
            ->with('success', $result['message']);
    }

    /**
     * Logout user
     */
    public function logout(Request $request): RedirectResponse
    {
        activity()
            ->causedBy(auth()->user())
            ->log('User logged out');

        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.otp.request')
            ->with('success', 'Logged out successfully.');
    }
}
