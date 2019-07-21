<?php

namespace Telegram\Dialogs\Fidelities;

use App\Facades\FidelityDialogService;
use Telegram\Dialog;
use Telegram\Dialogs\Traits\UtilsDialog;

class FidelityDialog extends Dialog
{
    use UtilsDialog;

    protected $id    = 'FidelityDialog';
    public $steps = [
        'options',
        'select',
        'available',
        'checkout'
    ];

    const CREATE    = 'Nova Fidelidade';
    const AVAILABLE = 'Fidelidades Ativas';
    const CHECKOUT  = 'Realizou o Pedido Hoje?';

    public function options()
    {
        $keyboard = [
            [self::CREATE],
            [self::AVAILABLE],
        ];

        $messageId = $this->sendMarkup($keyboard)->getMessageId();
        $this->remember($messageId);
    }

    public function select()
    {
        $this->deleteMessage();
        $this->deleteMessage($this->remember());

        switch ($this->optionSelected()) {
            case self::CREATE:
                $this->goDialog(new CreateFidelitiesTelegram($this->update));
                break;
            case self::AVAILABLE:
                $this->jump('available');
                break;
            default:
                $this->jump('options');
        }

        $this->proceed();
    }


    public function available()
    {
        $user     = $this->update->getMessage()->getFrom();
        $response = FidelityDialogService::available($user);

        $this->sendText($response);
        $this->end();
    }

    public function checkout()
    {
        $option = $this->update->getMessage()->getText();
        $user   = $this->update->getMessage()->getFrom();
        $last   = false;

        if($option == "Sim") {
            $last = FidelityDialogService::checkout($user);
            $this->sendText('Ok! Confirmamos que você realizou pedidos hoje.');
        }else {
            $this->sendText('Ok! Confirmamos que você NÃO realizou pedidos hoje.');
        }

        if($last) {
            $this->sendText("Hoje foi seu último dia de fidelidade.");
        } else {
            $this->sendText(FidelityDialogService::available($user));
        }

        $this->end();
    }
}
