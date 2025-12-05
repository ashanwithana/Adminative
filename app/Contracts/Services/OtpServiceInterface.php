<?php

namespace App\Contracts\Services;

use App\DTOs\OtpDTO;
use App\Models\Otp;

interface OtpServiceInterface
{
    public function generate(OtpDTO $dto): Otp;

    public function verify(string $identifier, string $code, string $type): bool;

    public function send(Otp $otp): bool;

    public function canResend(string $identifier, string $type): bool;

    public function cleanupExpired(): int;
}
