<?php

namespace App\Telegram\Commands;

use App\Telegram\Dialogs\FidelityDialog;
use BotDialogs\Laravel\Facades\Dialogs;
use Telegram\Bot\Commands\Command;

class FidelityCommand extends Command
{
    protected $name = 'fidelidade';
    protected $description = 'Gestão de Fidelidades';

    public function handle($arguments)
    {
        Dialogs::add(new FidelityDialog($this->update));
    }
}
