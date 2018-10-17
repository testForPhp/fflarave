<?php

namespace App\Repositories;

use App\Models\PayCodeLog;

class PayCodeLogRepository
{
    public $model;

    public function __construct()
    {
        $this->model = new PayCodeLog();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function orderByPaginate($order = 'id', $sort = 'desc', $limit = 20)
    {
        return $this->model->orderBy($order,$sort)->paginate($limit);
    }

}