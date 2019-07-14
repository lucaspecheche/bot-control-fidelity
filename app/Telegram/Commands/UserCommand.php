<?php

namespace App\Telegram\Commands;

use App\Telegram\Dialogs\UserDialog;
use BotDialogs\Laravel\Facades\Dialogs;
use Telegram\Bot\Commands\Command;

class UserCommand extends Command
{
    protected $name = 'user';
    protected $description = 'Gestão de Usuários';

    public function handle($arguments)
    {
        Dialogs::add(new UserDialog($this->update));
    }
}
