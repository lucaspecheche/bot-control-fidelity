<?php

namespace App\Telegram\Dialogs;

use App\Facades\UserDialogService;

class UserDialog extends Dialog
{
    protected $steps = ['options', 'response'];

    const CREATE  = 'Criar Usuário';
    const LISTING = 'Listar Usuários';
    const ADD_ME  = 'Criar Meu Usuário';

    public function options()
    {
        $keyboard = [
            [self::ADD_ME]
        ];

        $this->sendMarkup($keyboard);
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
}
