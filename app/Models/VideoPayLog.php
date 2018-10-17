<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoPayLog extends Model
{
    public $table = 'video_pay_log';

    public $fillable = ['user_id','video_id','point'];
}
