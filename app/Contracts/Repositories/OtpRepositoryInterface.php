<?php

namespace App\Contracts\Repositories;

use App\Models\Otp;
use App\Models\User;

interface OtpRepositoryInterface
{
    public function create(array $data): Otp;

    public function findValidOtp(string $identifier, string $code, string $type): ?Otp;

    public function incrementAttempts(Otp $otp): void;

    public function markAsVerified(Otp $otp): void;

    public function deleteExpiredOtps(): int;

    public function deleteUserOtps(string $identifier, string $type): void;

    public function getRecentOtp(string $identifier, string $type): ?Otp;
}
