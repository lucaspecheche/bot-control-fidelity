<?php

namespace App\Telegram\Commands;

use App\Telegram\Dialogs\UserManagementDialog;
use BotDialogs\Laravel\Facades\Dialogs;
use Telegram\Bot\Commands\Command;

class UserManagementCommand extends Command
{
    protected $name = 'users';
    protected $description = 'Gestão de Usuários';

    public function handle($arguments)
    {
        Dialogs::add(new UserManagementDialog($this->update));
    }
}
