<?php

namespace App\Contracts\Services;

interface SmsServiceInterface
{
    public function send(string $to, string $message): bool;

    public function sendOtp(string $to, string $code): bool;
}
