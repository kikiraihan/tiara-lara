<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Utils\TelegramHelper;

class LoginTelegramLogger
{
    public function handle(Login $event)
    {
        $user = $event->user;
        $ip = request()->ip();
        $agent = request()->userAgent();

        $message = "🔐 Login Detected:\n".
                   "👤 User: {$user->name} (ID: {$user->id})\n".
                   "🌍 IP: {$ip}\n".
                   "📱 Agent: {$agent}";

        TelegramHelper::send($message);
    }
}
