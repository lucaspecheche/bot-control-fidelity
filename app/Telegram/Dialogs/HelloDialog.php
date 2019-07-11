<?php
namespace App\Telegram\Dialogs;

use BotDialogs\Dialog;

class HelloDialog extends Dialog
{
    protected $steps = ['hello', 'bye'];

    public function hello()
    {
        $keyboard = [
            ['Mateus'],
            ['Lucas']
        ];

        $reply_markup = $this->telegram->replyKeyboardMarkup([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
            //'selective' => true
        ]);

        $this->telegram->sendMessage([
            'chat_id' => $this->getChat()->getId(),
            'text' => 'lucas',
            'reply_markup' => $reply_markup
        ]);
    }

    public function bye()
    {
        $reply_markup = $this->telegram->replyKeyboardMarkup([
            'remove_keyboard'=> true
        ]);

        $this->telegram->sendMessage([
            'chat_id' => $this->getChat()->getId(),
            'text' => 'Bye!',
            'reply_markup' => $reply_markup
        ]);
        $this->end();
    }

    public function fine()
    {
        $this->telegram->sendMessage([
            'chat_id' => $this->getChat()->getId(),
            'text' => 'I\'m OK :)'
        ]);
    }
}
