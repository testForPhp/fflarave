<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','device'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function program()
    {
        return $this->hasOne(new Program(),'id','program_id');
    }

    public function payUserLog()
    {
        return $this->hasMany(new PayCodeLog(),'user_id','id');
    }

    public function collect()
    {
        return $this->hasManyThrough('App\Models\Video','App\Models\Collect','user_id','id','id','video_id');
    }

    public function sendPasswordResetNotification($token)
    {
        $data['token'] = url('/password/reset',$token);
        $data['name'] = $this->name;
        $data['website'] = cache('system_base')->website;
        $data['email'] = cache('system_base')->email;

        Mail::to($this->email)->send(new \App\Mail\ForgotPassword($data));
    }
}
