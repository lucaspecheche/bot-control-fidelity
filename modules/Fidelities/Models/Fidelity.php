<?php

namespace Fidelities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Users\Models\User;

class Fidelity extends Model
{
    use SoftDeletes;

    protected $fillable = ['label', 'startAt', 'amount', 'remainder', 'user_id'];
    public $timestamps = false;

    public function firstOrCreate(array $attributes): Fidelity
    {
        $fidelity = $this->newQuery()->firstOrCreate($attributes);
        return $fidelity;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
