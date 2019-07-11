<?php

namespace App\Facades;

use App\Services\UserService as Service;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Service createAndChat(\Telegram\Bot\Objects\User $attributes)
 *
 * @see Service
 */
class UserService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return resolve(Service::class);
    }
}
