<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReflectVideo extends Model
{
    public $table = 'reflect_videos';

    public $fillable = ['video_id','user_id'];

    public function user()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function video()
    {
        return $this->hasOne('App\Models\Video','id','video_id');
    }
}
