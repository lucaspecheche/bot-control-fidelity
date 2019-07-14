<?php

namespace App\Telegram\Dialogs;

use App\Facades\FidelityDialogService;
use App\Helpers\DateHelper;
use Carbon\Carbon;

class FidelityDialog extends Dialog
{
    protected $id    = 'FidelityDialog';
    public $steps = [
        'options',
        'select',
        'create',
        'createStartAt',
        'createAmount',
        'available',
        'checkout',
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

        $message = $this->sendMarkup($keyboard);
        $this->remember($message->getMessageId());
    }

    public function select()
    {
        $this->deleteMessage();
        $this->deleteMessage($this->remember());

        switch ($this->optionSelected()) {
            case self::CREATE:
                $this->jump('create');
                break;
            case self::AVAILABLE:
                $this->jump('available');
                break;
            default:
                $this->jump('options');
        }

        $this->proceed();
    }

    public function create()
    {
        if($this->isToExit()){
            return "Exit";
        }

        $string = "Informe a data inicial da Fidelidade (Carbon Resolve para vc)";

        $this->sendText($string);
        $this->jump('createStartAt');
    }

    public function createStartAt()
    {
        $date = $this->update->getMessage()->getText();

        if(DateHelper::validate($date)) {
            $dateFormatted = Carbon::parse($date)->toDateString();
            $this->remember($dateFormatted);

            $string = "Ok! Entendemos que a data inicial será: ${dateFormatted}.\nAgora nos informe a quantidade contratada.";
            $this->sendText($string);
            $this->jump('createAmount');
        } else {
            $this->sendText('Data Incorreta!');
            $this->jump('create');
            $this->proceed();
        }
    }

    public function createAmount()
    {
        $amount = $this->update->getMessage()->getText();
        $user   = $this->update->getMessage()->getFrom();
        $date   = $this->remember();

        $this->sendText(FidelityDialogService::create($date, $amount, $user));
        $this->sendText(FidelityDialogService::available($user));
        $this->end();
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
