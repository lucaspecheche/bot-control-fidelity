<?php

namespace Users\Telegram\Commands;

use Telegram\Bot\Commands\Command;
use Telegram\Facades\Dialogs;
use Users\Telegram\Dialogs\UserDialog;

class UserCommand extends Command
{
    protected $name = 'user';
    protected $description = 'Gestão de Usuários';

    public function handle($arguments)
    {
        Dialogs::add(resolve(UserDialog::class));
    }
}
