<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemServer extends Model
{
    public $fillable = ['name','site','is_active'];
}
