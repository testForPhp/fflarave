<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sort extends Model
{
    public $table = 'video_sort';

    public $fillable = ['name','sort','is_home','father_id'];

    public function videos()
    {
        return $this->hasMany('App\Models\Video','sort','id');
    }

    public function idByVideoPaginate($order = 'id', $sort = 'desc', $limit = 36)
    {
        return $this->videos()->where('status',1)->orderBy($order,$sort)->paginate($limit);
    }

    public function home()
    {
        return $this->videos()
            ->where('status',1)
            ->orderBy('updated_at','desc')
            ->limit(8)
            ->get();
    }
}
