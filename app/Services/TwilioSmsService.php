<?php

namespace App\Services;

use App\Contracts\Services\SmsServiceInterface;
use Twilio\Rest\Client;

class TwilioSmsService implements SmsServiceInterface
{
    private ?Client $client;

    public function __construct()
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');

        $this->client = ($sid && $token) ? new Client($sid, $token) : null;
    }

    public function send(string $to, string $message): bool
    {
        if (!$this->client) {
            logger()->warning('Twilio not configured, using mock SMS service');
            return $this->mockSend($to, $message);
        }

        try {
            $this->client->messages->create($to, [
                'from' => config('services.twilio.from'),
                'body' => $message,
            ]);

            logger()->info('SMS sent successfully', ['to' => $to]);
            return true;
        } catch (\Exception $e) {
            logger()->error('Failed to send SMS', [
                'to' => $to,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    public function sendOtp(string $to, string $code): bool
    {
        $message = "Your OTP code is: {$code}. Valid for 10 minutes.";
        return $this->send($to, $message);
    }

    private function mockSend(string $to, string $message): bool
    {
        logger()->info('MOCK SMS', [
            'to' => $to,
            'message' => $message,
        ]);
        return true;
    }
}
