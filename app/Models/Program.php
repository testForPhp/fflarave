<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    public $fillable = ['title','summary','time','total','sales','sort'];
}
