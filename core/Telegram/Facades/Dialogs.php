<?php

namespace Telegram\Facades;

use Illuminate\Support\Facades\Facade;
use Telegram\Dialog;

/**
 * @method static \Telegram\Dialogs add(Dialog $dialog)
 * @method static \Telegram\Dialogs jump(Dialog $dialog)
 *
 * @see \Telegram\Dialogs
 */
class Dialogs extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Telegram\Dialogs::class;
    }
}
