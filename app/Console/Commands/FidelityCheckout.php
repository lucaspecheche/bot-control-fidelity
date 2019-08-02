<?php

namespace App\Console\Commands;

use Fidelities\Models\Fidelity;
use Fidelities\Telegram\Dialogs\FidelityDialog;
use Telegram\Dialogs;
use Illuminate\Console\Command;
use Telegram\Telegram;

class FidelityCheckout extends Command
{
    protected $signature   = 'fidelity:checkout';
    protected $description = 'Confirma o pedido diariamente';

    public function handle(Dialogs $dialogs, Telegram $telegram)
    {
       $fidelities = Fidelity::query()->where('startAt','<=', now())->get();

       foreach ($fidelities as $fidelity) {
           $user   = $fidelity->user;
           $chatId = $user->chats->first()->chat;

           $dialogs->schedule($chatId, 3, FidelityDialog::class);
           $this->sendCheckout($telegram, $chatId);
       }

       $this->info('Process Complete');
    }

    private function sendCheckout(Telegram $telegram, int $chatId)
    {
        $keyboard = [
            ['Sim'],
            ['Não'],
        ];

        $reply_markup = $telegram->replyKeyboardMarkup([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
        ]);

        $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => 'Você realizou algum pedido hoje?',
            'reply_markup' => $reply_markup
        ]);
    }
}
