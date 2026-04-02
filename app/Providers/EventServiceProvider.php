<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Listeners\LogLoginListener;
use App\Listeners\LogLogoutListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            LogLoginListener::class,
        ],
        Logout::class => [
            LogLogoutListener::class,
        ],
    ];

    public function boot(): void {}
}
