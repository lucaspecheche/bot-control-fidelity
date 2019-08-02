<?php

namespace Users\Telegram\Dialogs;

use Telegram\Bot\Objects\Update;
use Telegram\Dialog;
use Telegram\Traits\UtilsDialog;

class UserDialog extends Dialog
{
    use UtilsDialog;

    protected $steps = ['options', 'response'];
    protected $service;


    public function __construct(Update $update, UserDialogService $service)
    {
        $this->service = $service;
        parent::__construct($update);
    }


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
                $response = $this->service->createAndChat($this->update);
                break;
        }

        $this->telegram->sendMessage([
            'chat_id' => $this->getChat()->getId(),
            'text' => $response
        ]);
    }
}
