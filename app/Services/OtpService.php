<?php

namespace App\Services;

use App\Contracts\Repositories\OtpRepositoryInterface;
use App\Contracts\Services\OtpServiceInterface;
use App\Contracts\Services\SmsServiceInterface;
use App\DTOs\OtpDTO;
use App\Models\Otp;
use App\Notifications\OtpNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class OtpService implements OtpServiceInterface
{
    public function __construct(
        private readonly OtpRepositoryInterface $otpRepository,
        private readonly SmsServiceInterface $smsService
    ) {}

    public function generate(OtpDTO $dto): Otp
    {
        // Delete any existing unverified OTPs
        $this->otpRepository->deleteUserOtps($dto->identifier, $dto->type);

        // Generate 6-digit OTP
        $code = str_pad((string) random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

        // Create OTP record
        $otp = $this->otpRepository->create([
            'user_id' => $dto->userId,
            'identifier' => $dto->identifier,
            'code' => hash('sha256', $code),
            'type' => $dto->type,
            'channel' => $dto->channel,
            'expires_at' => Carbon::now()->addMinutes(10),
            'ip_address' => $dto->ipAddress,
            'user_agent' => $dto->userAgent,
        ]);

        // Store plain code temporarily for sending (not saved in DB)
        $otp->plain_code = $code;

        return $otp;
    }

    public function verify(string $identifier, string $code, string $type): bool
    {
        $otp = $this->otpRepository->findValidOtp($identifier, $code, $type);

        if (!$otp) {
            return false;
        }

        if (!$otp->isValid()) {
            return false;
        }

        $this->otpRepository->markAsVerified($otp);

        return true;
    }

    public function send(Otp $otp): bool
    {
        if (!isset($otp->plain_code)) {
            return false;
        }

        if ($otp->channel === 'email') {
            return $this->sendEmail($otp);
        }

        if ($otp->channel === 'sms') {
            return $this->sendSms($otp);
        }

        return false;
    }

    public function canResend(string $identifier, string $type): bool
    {
        $recentOtp = $this->otpRepository->getRecentOtp($identifier, $type);

        if (!$recentOtp) {
            return true;
        }

        // Allow resend only after 1 minute
        return $recentOtp->created_at->addMinute()->isPast();
    }

    public function cleanupExpired(): int
    {
        return $this->otpRepository->deleteExpiredOtps();
    }

    private function sendEmail(Otp $otp): bool
    {
        try {
            Notification::route('mail', $otp->identifier)
                ->notify(new OtpNotification($otp->plain_code, $otp->type));
            return true;
        } catch (\Exception $e) {
            logger()->error('Failed to send OTP email', [
                'identifier' => $otp->identifier,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    private function sendSms(Otp $otp): bool
    {
        try {
            return $this->smsService->sendOtp($otp->identifier, $otp->plain_code);
        } catch (\Exception $e) {
            logger()->error('Failed to send OTP SMS', [
                'identifier' => $otp->identifier,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }
}
