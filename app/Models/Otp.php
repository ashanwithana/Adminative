<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Otp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'identifier',
        'code',
        'type',
        'channel',
        'expires_at',
        'attempts',
        'verified',
        'verified_at',
        'ip_address',
        'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'verified_at' => 'datetime',
            'verified' => 'boolean',
            'attempts' => 'integer',
        ];
    }

    /**
     * Get the user that owns the OTP
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if OTP is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Check if OTP is valid
     */
    public function isValid(): bool
    {
        return !$this->verified && !$this->isExpired() && $this->attempts < 3;
    }

    /**
     * Verify the OTP code
     */
    public function verifyCode(string $code): bool
    {
        return hash_equals($this->code, hash('sha256', $code));
    }
}
