<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = ['content', 'publish_at', 'unpublish_at'];
    protected $hidden = ['created_at', 'updated_at'];
}
