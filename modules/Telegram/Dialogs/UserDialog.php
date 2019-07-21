<?php

namespace Telegram\Dialogs;

use App\Facades\UserDialogService;
use Telegram\Dialog;
use Telegram\Dialogs\Fidelities\CreateFidelitiesTelegram;
use Telegram\Dialogs\Traits\UtilsDialog;

class UserDialog extends Dialog
{
    use UtilsDialog;

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
                break;
            case self::LISTING:
                $this->goDialog(new CreateFidelitiesTelegram($this->update));
                return;
        }

        $this->telegram->sendMessage([
            'chat_id' => $this->getChat()->getId(),
            'text' => $response
        ]);
    }
}
