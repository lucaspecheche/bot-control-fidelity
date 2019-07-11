<?php

namespace App\Http\Controllers;

use App\Telegram;
use BotDialogs\Dialogs;
use Illuminate\Http\Request;
use Telegram\Bot\Api;

class WebHookController extends Controller
{
    private $dialogs;
    private $telegram;

    public function __construct(Dialogs $dialogs, Api $telegram)
    {
        $this->dialogs  = $dialogs;
        $this->telegram = $telegram;
    }

    public function getUpdates()
    {
        $update = $this->telegram->commandsHandler(true);
        $this->dialogs->exists($update) && $this->dialogs->proceed($update);
    }

    public function setWebhook(Request $request)
    {
        $url = $request->get('url', url('/'));
        return $this->telegram->setWebhook(['url' => $url]);
    }

    public function removeWebhook()
    {
        return $this->telegram->removeWebhook()->getDecodedBody();
    }
}
