<?php

namespace Telegram\Dialogs\Traits;

use Telegram\Bot\Objects\Message;

trait UtilsDialog
{
    public function deleteMessage($messageId = null)
    {
        $chatId    = $this->getChat()->getId();
        $message = $messageId ?? $this->update->getMessage()->getMessageId();

        $this->telegram->deleteMessage($chatId, $message);
    }

    public function sendMarkup($keyboard): Message
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

    public function getText(): string
    {
        return $this->update->getMessage()->getText();
    }

    public function isToExit()
    {
        if($this->optionSelected() == 'sair') {
            $this->end();
            return true;
        }
        return false;
    }
}
