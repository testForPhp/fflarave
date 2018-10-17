<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
    public $table = 'notify';

    public $fillable = ['title','content'];
}
