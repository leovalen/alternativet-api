<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = ['message', 'url', 'publish_at', 'unpublish_at'];
    protected $hidden = ['created_at', 'updated_at'];
}
