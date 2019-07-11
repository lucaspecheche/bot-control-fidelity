<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'id_third_party', 'first_name', 'last_name', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function findOrNew(array $attributes): User
    {
        $user = $this->newQuery()->firstOrCreate($attributes)->first();
        return $user;
    }

    public function chats()
    {
        return $this->hasMany(Chat::class, 'user_id','');
    }
}

