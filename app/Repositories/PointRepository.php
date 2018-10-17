<?php

namespace App\Repositories;

use App\Models\Point;

class PointRepository
{
    public $model;

    public function __construct()
    {
        $this->model = new Point();
    }

    public function orderByPaginate($order, $sort = 'ASC', $limit = 20)
    {
        return $this->model->orderBy($order,$sort)->paginate($limit);
    }

    public function whereOrderByGet($where = [], $order = 'sort', $sort = 'asc')
    {
        $query = $this->model;
        if(count($where) > 0){
            foreach ($where as $key=>$val){
                $query = $this->model->where($key,$val);
            }
        }
        return $query->orderBy($order,$sort)->get();
    }

    public function whereByUpdate($key,$value,$data)
    {
        return $this->model->where($key,$value)->update($data);
    }

    public function whereFirst($where)
    {
        $query = null;
        foreach ($where as $key=>$value){
            $query = $this->model->where($key,$value);
        }
        return $query->first();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function destroy(Point $point)
    {
        return $point->delete();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }
}