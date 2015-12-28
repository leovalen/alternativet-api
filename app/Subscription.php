<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Contracts\Billable as BillableContract;

class Subscription extends Model implements BillableContract
{
    protected $dates = ['trial_ends_at', 'ends_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}