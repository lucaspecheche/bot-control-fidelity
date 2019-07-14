<?php

namespace App\Telegram\Dialogs;

use App\Telegram\Telegram;
use BotDialogs\Dialog as DialogBot;

class Dialog extends DialogBot
{
    const EXIT = 'sair';

    public function sendMarkup($keyboard)
    {
        $reply_markup = $this->telegram->replyKeyboardMarkup([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
        ]);

        return $this->telegram->sendMessage([
            'chat_id' => $this->getChat()->getId(),
            'parse_mode' => 'HTML',
            'text' => '<b>Selecione uma opção:</b>',
            'reply_markup' => $reply_markup
        ]);
    }

    public function sendText(string $text)
    {
        $this->telegram->sendMessage([
            'chat_id' => $this->getChat()->getId(),
            'text'    => $text
        ]);
    }

    public function optionSelected(): string
    {
        return $this->update->getMessage()->getText();
    }

    public function deleteMessage($messageId = null)
    {
        $telegram  = resolve(Telegram::class);
        $chatId    = $this->getChat()->getId();

        $message = $messageId ?? $this->update->getMessage()->getMessageId();

        $telegram->deleteMessage($chatId, $message);
    }

    public function getId()
    {
        return $this->id;
    }

    public function isToExit()
    {
        if($this->optionSelected() == self::EXIT) {
            $this->end();
            return true;
        }
        return false;
    }
}
