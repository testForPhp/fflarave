<?php

namespace App\Repositories;


use App\Models\ReflectVideo;

class ReflectVideoRepository
{
    public $model;

    public function __construct()
    {
        $this->model = new ReflectVideo();
    }

    public function orderByPaginate($order = 'id', $sort = 'desc', $limit = 20)
    {
        return $this->model->orderBy($order,$sort)->paginate();
    }
    
    public function whereFirst($userId,$videoId)
    {
        return $this->model->where('user_id',$userId)
            ->where('video_id',$videoId)
            ->first();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }


}