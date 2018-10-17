<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Video extends Model
{
    public $fillable = ['name','pixel','sort','region','is_vip','point','time_limit','is_banner','thumbnail','link','view','preview'];

    public function collect()
    {
        return $this->hasMany(new Collect(),'video_id','id');
    }

    public function isCollect()
    {
        return $this->collect()->where('user_id',Auth::id())->first();
    }

    public function videoSort()
    {
        return $this->hasOne('App\Models\Sort','id','sort');
    }

    public function tags()
    {
        return $this->hasManyThrough('App\Models\Tag','App\Models\VideoToTag','video_id','id','id','tag_id');
    }

    public function pointData()
    {
        return [
            '高清',
            '720P',
            '1080p',
            '4k'
        ];
    }

    public function city()
    {
        return [
            'china' =>'中國',
            'jp' => '日韓',
            'us' => '歐美'
        ];
    }

}
