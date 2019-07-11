<?php

namespace App\Facades;

use App\Services\UserDialogService as DialogService;
use Illuminate\Support\Facades\Facade;
use Telegram\Bot\Objects\Update;

/**
 * @method static DialogService createAndChat(Update $from)
 *
 * @see DialogService
 */
class UserDialogService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return resolve(DialogService::class);
    }
}
