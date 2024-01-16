<?php

namespace App\Services\Telegram;

use App\Logging\Telegram\Exception\TelegramBotApiException;
use Illuminate\Support\Facades\Http;

class TelegramBotApi
{
    public const HOST = 'https://api.telegram.org/bot';

    public static function sendMessage(string $token, int $chatId, string $text)
    {
        try {
            $response = Http::get(self::HOST . $token . '/sendMessage', [
                'chat_id'    => $chatId,
                'text'       => $text
            ])
                ->throw()
                ->json();

            return $response['ok'] ?? false;
        } catch (\Throwable $e) {
            report(new TelegramBotApiException($e->getMessage()));

            return false;
        }
    }
}
