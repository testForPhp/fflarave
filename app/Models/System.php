<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    public $fillable = ['website','url','email','imgServer','count','logo','ads_1','ads_2','ads_1_link','ads_2_link'];
}
