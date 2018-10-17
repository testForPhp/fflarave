<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoToTag extends Model
{
    public $table = 'video_to_tag';

    public $fillable = ['video_id','tag_id'];
}
