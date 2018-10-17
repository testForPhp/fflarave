<?php

namespace App\Repositories;


use App\Models\Tag;

class TagRepository
{
    public $model;

    public function __construct()
    {
        $this->model = new Tag();
    }

    public function orderByPaginate($key,$column = 'ASC')
    {
        return $this->model->orderBy($key,$column)->paginate(20);
    }

    public function whereIdByUpdate($id,$data)
    {
        return $this->model->where('id',$id)->update($data);
    }

    public function orderByGet($key, $value = 'ASC')
    {
        return $this->model->orderBy($key,$value)->get();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    
    public function whereFirst($key, $value)
    {
        return $this->model->where($key,$value)->first();
    }

    public function destroy(Tag $tag)
    {
        return $tag->delete();
    }
}