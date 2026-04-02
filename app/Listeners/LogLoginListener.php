<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class LogLoginListener
{
    public function handle(Login $event)
    {
        \catatLog('login', 'User berhasil login');
    }
}
