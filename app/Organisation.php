<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{
    public function appointments()
    {
        $this->belongsToMany('App\Appointment');
    }
}
