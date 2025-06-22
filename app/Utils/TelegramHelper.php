<?php

namespace App\Utils;

use Illuminate\Support\Facades\Http;

class TelegramHelper
{
    public static function send($message)
    {
        $token = env('TELEGRAM_BOT_TOKEN'); // ← Ganti ini dengan token asli dari BotFather
        $chat_id = env('TELEGRAM_BOT_CHAT_ID');           // ← Ganti ini dengan chat ID kamu

        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        Http::get($url, [
            'chat_id' => $chat_id,
            'text' => $message,
        ]);
    }
}
