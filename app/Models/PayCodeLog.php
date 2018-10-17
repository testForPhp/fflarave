<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayCodeLog extends Model
{
    public $table = 'pay_code_log';

    public $fillable = ['user_id','code_id','code','money','point','summary','type'];

    public function user()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }
}
