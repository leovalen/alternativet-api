<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{
    protected $fillable = ['name', 'type', 'orgnr'];

    public function appointments()
    {
        $this->belongsToMany('App\Appointment');
    }
}
