<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Contracts\Billable as BillableContract;

class Membership extends Model implements BillableContract
{
    use Billable;

    protected $dates = ['trial_ends_at', 'subscription_ends_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}