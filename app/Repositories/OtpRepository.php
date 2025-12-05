<?php

namespace App\Repositories;

use App\Contracts\Repositories\OtpRepositoryInterface;
use App\Models\Otp;
use Carbon\Carbon;

class OtpRepository implements OtpRepositoryInterface
{
    public function create(array $data): Otp
    {
        return Otp::create($data);
    }

    public function findValidOtp(string $identifier, string $code, string $type): ?Otp
    {
        $hashedCode = hash('sha256', $code);

        return Otp::where('identifier', $identifier)
            ->where('code', $hashedCode)
            ->where('type', $type)
            ->where('verified', false)
            ->where('expires_at', '>', Carbon::now())
            ->where('attempts', '<', 3)
            ->first();
    }

    public function incrementAttempts(Otp $otp): void
    {
        $otp->increment('attempts');
    }

    public function markAsVerified(Otp $otp): void
    {
        $otp->update([
            'verified' => true,
            'verified_at' => Carbon::now(),
        ]);
    }

    public function deleteExpiredOtps(): int
    {
        return Otp::where('expires_at', '<', Carbon::now())->delete();
    }

    public function deleteUserOtps(string $identifier, string $type): void
    {
        Otp::where('identifier', $identifier)
            ->where('type', $type)
            ->where('verified', false)
            ->delete();
    }

    public function getRecentOtp(string $identifier, string $type): ?Otp
    {
        return Otp::where('identifier', $identifier)
            ->where('type', $type)
            ->latest()
            ->first();
    }
}
