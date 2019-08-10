<?php

namespace Telegram\Http\Controllers;

use App\Http\Controllers\Controller;
use Telegram\Dialogs;
use Illuminate\Http\Request;
use Telegram\Telegram;

class WebHookTelegramController extends Controller
{
    const ROUTE = '/telegram/updates';

    private $dialogs;
    private $telegram;

    public function __construct(Dialogs $dialogs, Telegram $telegram)
    {
        $this->dialogs  = $dialogs;
        $this->telegram = $telegram;
    }

    public function getUpdates()
    {
        try {
            $this->dialogs->start();
        } catch (\Exception $exception) {
           echo 'ocorreu um erro';
        }

    }

    public function setWebhook(Request $request)
    {
        $url = $request->get('url').self::ROUTE;
        return $this->telegram->setWebhook(['url' => $url]);
    }

    public function removeWebhook()
    {
        return $this->telegram->removeWebhook()->getDecodedBody();
    }
}
