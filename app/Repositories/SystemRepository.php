<?php

namespace App\Repositories;


use App\Models\System;
use Illuminate\Support\Facades\Cache;

class SystemRepository
{
    public $model;

    public function __construct()
    {
        $this->model = new System();
    }

    public function first()
    {
        return $this->model->first();
    }

    public function create($data)
    {
        $result = $this->model->create($data);
        $this->cache();
        return $result;
    }

    public function whereUpdate($key,$val,$data)
    {
        $result = $this->model->where($key,$val)->update($data);
        $this->cache();
        return $result;
    }

    public function checkCache()
    {
        if(Cache::has('system_base') == false){
             $this->cache();
        }
        return Cache::get('system_base');
    }

    public function cache()
    {
        if(Cache::has('system_base')){
            Cache::forget('system_base');
        }
        return Cache::forever('system_base',$this->first());
    }
}