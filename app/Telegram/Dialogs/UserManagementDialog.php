<?php

namespace App\Telegram\Dialogs;

use App\Facades\UserDialogService;
use App\Telegram\Telegram;

class UserManagementDialog extends Dialog
{
    protected $steps = ['options', 'response'];

    const CREATE  = 'Criar Usuário';
    const LISTING = 'Listar Usuários';
    const ADD_ME  = 'Criar Meu Usuário';

    public function options()
    {
        $keyboard = [
            //[self::CREATE],
            [self::LISTING],
            [self::ADD_ME]
        ];

        $reply_markup = $this->telegram->replyKeyboardMarkup([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
        ]);

        $this->telegram->sendMessage([
            'chat_id' => $this->getChat()->getId(),
            'text' => 'Selecione uma opção:',
            'reply_markup' => $reply_markup
        ]);
    }

    public function response()
    {
        $response = '';

        switch ($this->optionSelected()) {
            case self::ADD_ME:
                $response = UserDialogService::createAndChat($this->update);
        }

        $this->telegram->sendMessage([
            'chat_id' => $this->getChat()->getId(),
            'text' => $response
        ]);
    }

    private function optionSelected(): string
    {
        return $this->update->getMessage()->getText();
    }

    private function delete()
    {
        $messageId = $this->update->getMessage()->getMessageId();
        $chatId = $this->update->getMessage()->getChat()->getId();

        $api = resolve(Telegram::class);
        $api->deleteMessage($chatId, $messageId);
    }
}
