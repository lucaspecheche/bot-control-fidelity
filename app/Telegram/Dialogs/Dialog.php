<?php

namespace App\Telegram\Dialogs;

use App\Telegram\Telegram;
use BotDialogs\Dialog as DialogBot;
use Telegram\Bot\Objects\Update;

class Dialog extends DialogBot
{
    protected $telegram;

    public function __construct(Update $update, bool $autoimport = false)
    {
        parent::__construct($update, $autoimport);
        $this->telegram = $this->telegram();
    }

    private function telegram(): Telegram
    {
        return resolve(Telegram::class);
    }
}
