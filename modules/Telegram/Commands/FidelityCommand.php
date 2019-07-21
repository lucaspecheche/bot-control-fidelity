<?php

namespace Telegram\Commands;

use Telegram\Dialogs\Fidelities\FidelityDialog;
use Telegram\Facades\Dialogs;
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
