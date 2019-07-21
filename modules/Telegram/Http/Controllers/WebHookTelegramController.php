<?php

namespace Telegram\Http\Controllers;

use App\Http\Controllers\Controller;
use Telegram\Dialogs;
use Illuminate\Http\Request;
use Telegram\Telegram;

class WebHookTelegramController extends Controller
{
    private $dialogs;
    private $telegram;

    public function __construct(Dialogs $dialogs, Telegram $telegram)
    {
        $this->dialogs  = $dialogs;
        $this->telegram = $telegram;
    }

    public function getUpdates()
    {
        $update = $this->telegram->commandsHandler(true);

        if($this->dialogs->exists($update))
            $this->dialogs->proceed($update);

//        try {
//
//        } catch (\Exception $exception) {
//            $update = $this->telegram->getWebhookUpdates();
//            $update->getMessage()->getChat()->getId();
//
//            $from = $update->getMessage()->toArray();
//            \Illuminate\Support\Facades\Log::debug('Debug: ', $from);
//
//
//            $this->telegram->sendMessage([
//                'chat_id' => $update->getMessage()->getChat()->getId(),
//                'text'    => 'Ocorreu um erro Interno ao processar o comando.'
//            ]);
//        }
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
