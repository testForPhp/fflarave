<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $table = 'video_tags';

    public $fillable = ['title'];
}
