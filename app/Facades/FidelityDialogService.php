<?php

namespace App\Facades;

use App\Services\FidelityDialogService as Service;
use Illuminate\Support\Facades\Facade;
use Telegram\Bot\Objects\User;

/**
 * @method static Service create(string $date, string $amount, User $user)
 * @method static available(User $user)
 * @method static checkout(User $user)
 */
class FidelityDialogService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return resolve(Service::class);
    }
}
