<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;

class AdminUser extends User
{
    use Notifiable;

    public $table = 'admin_users';

}
