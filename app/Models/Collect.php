<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collect extends Model
{
    public $table = 'collects';

    public $fillable = ['user_id','video_id'];
}
