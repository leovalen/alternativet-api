<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $dates = ['trial_ends_at', 'ends_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}