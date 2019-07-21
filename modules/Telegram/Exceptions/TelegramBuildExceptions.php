<?php

namespace Telegram\Exceptions;

use Illuminate\Http\Response;
use Illuminate\Redis\RedisManager;
use Telegram\Telegram;

class TelegramBuildExceptions extends \Exception
{
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
        parent::__construct();
    }

    public function report(Telegram $telegram, RedisManager $redis)
    {
        $redis->del([$telegram->chatId()]);

        $telegram->sendMessage([
            'chat_id' => $telegram->chatId(),
            'text'    => $this->message
        ]);
    }

    public function render()
    {
        return response(['message' => "Erro: $this->message"], Response::HTTP_OK);
    }

}
