<?php
namespace App\Repositories;

use App\Models\Notify;

class NotifyRepository
{
    public $model;

    public function __construct()
    {
        $this->model = new Notify();
    }

    public function whereFirst(array $where)
    {
        $query = null;
        if(empty($where)) return false;

        foreach ($where as $key=>$value){
            $query = $this->model->where($key,$value);
        }
        return $query->first();
    }

    public function orderByPaginate($order = 'id', $sort = 'desc', $limit = 20)
    {

        return $this->model->orderBy($order,$sort)->paginate($limit);
    }
    
    public function whereOrderByLimitGet(array $where = [], $order = 'id', $sort = 'desc', $limit = 5)
    {
        $query = $this->model;

        if(count($where) > 0){
           foreach ($where as $key=>$value){
               $query = $this->model->where($key,$value);
           }
        }

        return $query->orderBy($order,$sort)->limit($limit)->get();

    }


}