<?php

namespace App\Console\Commands;

use App\Models\Fidelity;
use App\Telegram\Dialogs\Dialogs;
use App\Telegram\Dialogs\FidelityDialog;
use Illuminate\Console\Command;

class FidelityCheckout extends Command
{
    protected $signature   = 'fidelity:checkout';
    protected $description = 'Confirma o pedido diariamente';

    public function handle(Dialogs $dialogs)
    {
       $fidelities = Fidelity::query()->where('startAt','<=', now())->get();

       foreach ($fidelities as $fidelity) {
           $user = $fidelity->user;
           $chatId = $user->chats->first()->chat;

           $dialogs->schedule($chatId, 6, FidelityDialog::class);
           $this->sendCheckout($dialogs->telegram, $chatId);
       }

       $this->info('Process Complete');
    }

    private function sendCheckout($telegram, $chatId)
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
