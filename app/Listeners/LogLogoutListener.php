<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;

class LogLogoutListener
{
    public function handle(Logout $event)
    {
        \catatLog('logout', 'User berhasil logout');
    }
}
