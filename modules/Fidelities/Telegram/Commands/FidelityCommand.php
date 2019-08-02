<?php

namespace Fidelities\Telegram\Commands;

use Fidelities\Telegram\Dialogs\FidelityDialog;
use Telegram\Facades\Dialogs;
use Telegram\Bot\Commands\Command;

class FidelityCommand extends Command
{
    protected $name = 'fidelidade';
    protected $description = 'Gestão de Fidelidades';

    public function handle($arguments)
    {
        Dialogs::add(resolve(FidelityDialog::class));
    }
}
