<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramUserLog extends Model
{
    public $table = 'program_user_log';

    public $fillable = ['user_id','program','money','summary'];
}
