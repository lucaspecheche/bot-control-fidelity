<?php

namespace App\Http\Controllers;

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
        try {

        } catch (\Exception $exception) {
            $update = $this->telegram->getWebhookUpdates();

            $this->telegram->sendMessage([
                'chat_id' => $update->getMessage()->getChat()->getId(),
                'text'    => 'Ocorreu um erro Interno ao processar o comando.'
            ]);

            var_dump($exception);
        }
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
