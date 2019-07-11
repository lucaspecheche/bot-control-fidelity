<?php

namespace App\Telegram\Commands;

use App\Telegram\Dialogs\HelloDialog;
use BotDialogs\Laravel\Facades\Dialogs;
use Telegram\Bot\Commands\Command;

class HelloCommand extends Command
{
    protected $name = 'hello';
    protected $description = 'Just say "Hello" and ask few questions';

    public function handle($arguments)
    {
        Dialogs::add(new HelloDialog($this->update));
    }
}
