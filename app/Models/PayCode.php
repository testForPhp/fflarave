<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayCode extends Model
{
    public $table = 'pay_codes';

    public $fillable = ['code','point_id'];

    public function point()
    {
        return $this->belongsTo(new Point(),'point_id','id');
    }
}
