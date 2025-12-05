<?php

namespace App\Providers;

use App\Contracts\Repositories\OtpRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\OtpServiceInterface;
use App\Contracts\Services\SmsServiceInterface;
use App\Repositories\OtpRepository;
use App\Repositories\UserRepository;
use App\Services\OtpService;
use App\Services\TwilioSmsService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        OtpRepositoryInterface::class => OtpRepository::class,
        UserRepositoryInterface::class => UserRepository::class,
        OtpServiceInterface::class => OtpService::class,
        SmsServiceInterface::class => TwilioSmsService::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
