<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRepository
{
    public function whereUpdate(array $data)
    {
        $user = $this->user();

        foreach ($data as $key=>$val){
            if($val){
                $user->$key = $val;
            }
        }
        return$user->save();
    }

    public function orderByPaginate($order = 'id', $sort = 'desc', $limit = 20)
    {
        return $this->init()->orderBy($order,$sort)->paginate($limit);
    }

    public function init()
    {
        return new User();
    }

    public function collectOrderByPaginate($order = 'id', $sort = 'DESC', $limit = 8)
    {
        return $this->user()->collect()->orderBy($order,$sort)->paginate($limit);
    }

    public function payUserLogOrderByPaginate($order = 'id', $sort = 'desc', $limit = 20)
    {

        return $this->user()->payUserLog()->orderBy($order,$sort)->paginate($limit);
    }

    public function updatePassword($password)
    {
        $user = $this->user();
        $user->password = bcrypt($password);
        return $user->save();
    }

    public function checkVipEndDate()
    {
        $user = $this->user();

        if($user->vip_end_time < date('Y-m-d')){
            $user->is_vip = 0;
            $user->program_id = null;
            $user->vip_end_time=null;
            $user->save();
        }
    }

    public function create($data)
    {
        return $this->init()->create($data);
    }

    public function user()
    {
        return Auth::user();
    }
}