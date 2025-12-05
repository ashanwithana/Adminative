<?php

namespace App\Actions\Auth;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\OtpServiceInterface;
use App\DTOs\OtpDTO;
use App\DTOs\UserDTO;
use Illuminate\Support\Facades\Auth;

class RegisterWithOtpAction
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly OtpServiceInterface $otpService
    ) {}

    public function execute(array $data, string $code): array
    {
        $identifier = $data['email'] ?? $data['phone'];

        // Verify OTP
        if (!$this->otpService->verify($identifier, $code, 'registration')) {
            return [
                'success' => false,
                'message' => 'Invalid or expired OTP code.',
            ];
        }

        // Create user
        $userDTO = UserDTO::fromRequest($data);
        $user = $this->userRepository->create($userDTO->toArray());

        // Assign default role
        $user->assignRole('User');

        // Mark email/phone as verified
        if (!empty($data['email'])) {
            $user->email_verified_at = now();
        }
        if (!empty($data['phone'])) {
            $user->phone_verified_at = now();
        }
        $user->save();

        // Login user
        Auth::login($user, true);

        // Log activity
        activity()
            ->performedOn($user)
            ->causedBy($user)
            ->log('User registered via OTP');

        return [
            'success' => true,
            'user' => $user,
            'message' => 'Registration successful.',
        ];
    }
}
