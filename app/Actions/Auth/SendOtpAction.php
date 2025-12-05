<?php

namespace App\Actions\Auth;

use App\Contracts\Services\OtpServiceInterface;
use App\DTOs\OtpDTO;

class SendOtpAction
{
    public function __construct(
        private readonly OtpServiceInterface $otpService
    ) {}

    public function execute(OtpDTO $dto): array
    {
        // Check rate limiting
        if (!$this->otpService->canResend($dto->identifier, $dto->type)) {
            return [
                'success' => false,
                'message' => 'Please wait before requesting a new OTP.',
            ];
        }

        // Generate OTP
        $otp = $this->otpService->generate($dto);

        // Send OTP
        $sent = $this->otpService->send($otp);

        if (!$sent) {
            return [
                'success' => false,
                'message' => 'Failed to send OTP. Please try again.',
            ];
        }

        // Log activity
        activity()
            ->withProperties([
                'identifier' => $dto->identifier,
                'type' => $dto->type,
                'channel' => $dto->channel,
            ])
            ->log('OTP sent');

        return [
            'success' => true,
            'message' => 'OTP sent successfully.',
            'channel' => $dto->channel,
        ];
    }
}
