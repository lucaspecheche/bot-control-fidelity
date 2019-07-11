<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['chat', 'type', 'user_id'];

    public function create(array $attributes): Chat
    {
        $chat = $this->newQuery()->firstOrCreate($attributes);
        return $chat;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
