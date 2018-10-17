<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSpread extends Model
{
    public $table = 'user_spread';

    public $fillable = ['user_id','point','ip'];
}
