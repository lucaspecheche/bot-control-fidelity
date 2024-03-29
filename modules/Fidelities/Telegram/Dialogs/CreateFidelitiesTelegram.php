<?php

namespace Fidelities\Telegram\Dialogs;

use App\Helpers\DateHelper;
use Carbon\Carbon;
use Telegram\Bot\Objects\Update;
use Telegram\Dialog;
use Telegram\Traits\UtilsDialog;

class CreateFidelitiesTelegram extends Dialog
{
    use UtilsDialog;

    protected $service;
    protected $steps = [
        'info',
        'startAt',
        'amount'
    ];

    public function __construct(FidelityDialogService $service, Update $update)
    {
        $this->service = $service;
        parent::__construct($update);
    }

    public function info()
    {
        $this->sendText("Informe a data inicial da Fidelidade (Carbon Resolve para vc)");
        $this->jump('startAt');
    }

    public function startAt()
    {
        $date = $this->getText();

        if(DateHelper::validate($date)) {
            $dateFormatted = Carbon::parse($date)->toDateString();
            $this->remember($dateFormatted);

            $string = "Ok! Entendemos que a data inicial será: ${dateFormatted}.\nAgora nos informe a quantidade contratada.";
            $this->sendText($string);
            $this->jump('amount');
        } else {
            $this->sendText('Data Incorreta!');
            $this->jump('info');
            $this->proceed();
        }
    }

    public function amount()
    {
        $amount = $this->update->getMessage()->getText();
        $user   = $this->update->getMessage()->getFrom();
        $date   = $this->remember();

        if(is_numeric($amount)) {
            $this->sendText($this->service->create($date, $amount, $user));
            $this->sendText($this->service->available($user));
            $this->end();
        } else {
            $this->sendText('Quantidade informada Incorreta!');
            $this->jump('info');
            $this->proceed();
        }
    }
}
