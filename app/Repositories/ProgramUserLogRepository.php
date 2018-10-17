<?php

namespace App\Repositories;

use App\Models\ProgramUserLog;

class ProgramUserLogRepository
{
    public $model;

    public function __construct()
    {
        $this->model = new ProgramUserLog();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

}