<?php

namespace App\Telegram\Dialogs;

use Illuminate\Redis\RedisManager;
use Telegram\Bot\Api;

class Dialogs extends \BotDialogs\Dialogs
{
    public $telegram;

    public function __construct(Api $telegram, RedisManager $redis)
    {
        parent::__construct($telegram, $redis);
    }

    public function schedule(string $chatId, int $step, $class)
    {
        $this->setField($chatId, 'next', $step);
        $this->setField($chatId, 'dialog', $class);
    }
}
