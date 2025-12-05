<?php

namespace App\Actions\Auth;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\OtpServiceInterface;
use App\DTOs\OtpDTO;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginWithOtpAction
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly OtpServiceInterface $otpService
    ) {}

    public function execute(string $identifier, string $code): array
    {
        // Verify OTP
        if (!$this->otpService->verify($identifier, $code, 'login')) {
            return [
                'success' => false,
                'message' => 'Invalid or expired OTP code.',
            ];
        }

        // Find user
        $user = $this->userRepository->findByEmailOrPhone($identifier);

        if (!$user) {
            return [
                'success' => false,
                'message' => 'User not found.',
            ];
        }

        if (!$user->canLogin()) {
            return [
                'success' => false,
                'message' => 'Your account has been deactivated.',
            ];
        }

        // Login user
        Auth::login($user, true);

        // Update last login
        $this->userRepository->updateLastLogin($user);

        // Log activity
        activity()
            ->performedOn($user)
            ->causedBy($user)
            ->log('User logged in via OTP');

        return [
            'success' => true,
            'user' => $user,
            'message' => 'Login successful.',
        ];
    }
}
