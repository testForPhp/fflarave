<?php

namespace App\Repositories;

use App\Models\Collect;

class CollectRepository
{
    public $model;

    public function __construct()
    {
        $this->model = new Collect();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function destroy(Collect $collect)
    {
        return $collect->delete();
    }

    public function whereFirst($videoId,$userId)
    {
        return $this->model->where('video_id',$videoId)
            ->where('user_id',$userId)
            ->first();
    }

}