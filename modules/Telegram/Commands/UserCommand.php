<?php

namespace Telegram\Commands;

use Telegram\Dialogs\UserDialog;
use Telegram\Bot\Commands\Command;
use Telegram\Facades\Dialogs;

class UserCommand extends Command
{
    protected $name = 'user';
    protected $description = 'Gestão de Usuários';

    public function handle($arguments)
    {
        Dialogs::add(new UserDialog($this->update));
    }
}
