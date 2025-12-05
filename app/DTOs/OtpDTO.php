<?php

namespace App\DTOs;

class OtpDTO
{
    public function __construct(
        public readonly string $identifier,
        public readonly string $type,
        public readonly string $channel,
        public readonly ?int $userId = null,
        public readonly ?string $ipAddress = null,
        public readonly ?string $userAgent = null,
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            identifier: $data['identifier'],
            type: $data['type'] ?? 'login',
            channel: $data['channel'] ?? 'email',
            userId: $data['user_id'] ?? null,
            ipAddress: $data['ip_address'] ?? null,
            userAgent: $data['user_agent'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'identifier' => $this->identifier,
            'type' => $this->type,
            'channel' => $this->channel,
            'user_id' => $this->userId,
            'ip_address' => $this->ipAddress,
            'user_agent' => $this->userAgent,
        ];
    }
}
