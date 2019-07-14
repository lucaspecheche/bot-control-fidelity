<?php

namespace App\Telegram\Dialogs;

class Dialogs extends \BotDialogs\Dialogs
{
    public $telegram;

    public function schedule(string $chatId, int $step, $class)
    {
        $this->setField($chatId, 'next', $step);
        $this->setField($chatId, 'dialog', $class);
    }
}
