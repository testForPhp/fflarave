<?php

namespace App\Repositories;

use App\Models\Link;

class LinkRepository
{
    public $model;

    public function __construct()
    {
        $this->model = new Link();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function destroy(Link $link)
    {
        return $link->delete();
    }

    public function orderByGet($order, $sort = 'ASC')
    {
        return $this->model->orderBy($order,$sort)->get();
    }

    public function orderByPaginate($order, $sort = 'ASC', $limit = 20)
    {
        return $this->model->orderBy($order,$sort)->paginate($limit);
    }

    public function whereUpdate($key,$value,$data)
    {
        return $this->model->where($key,$value)->update($data);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }
}