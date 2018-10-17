<?php
/**
 * Created by PhpStorm.
 * User: rookie
 * Date: 2018/9/25
 * Time: 18:46
 */

namespace App\Repositories;


use App\Models\Program;
use Illuminate\Support\Facades\Cache;

class ProgramRepository
{
    public $model;

    public function __construct()
    {
        $this->model = new Program();
    }

    public function orderByPaginate($order, $sort = 'ASC', $limit = 20)
    {
        return $this->model->orderBy($order,$sort)->paginate($limit);
    }

    public function whereOrderByGet($where = [], $order = 'sort', $sort = 'ASC')
    {
        $query = $this->model;

        if(count($where) > 0){
            foreach ($where as $key=>$value){
                $query = $query->where($key,$value);
            }
        }
        return $query->orderBy($order,$sort)->get();
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

    public function destroy(Program $program)
    {
        $result = $program->delete();
        $this->removeCache();
        return $result;
    }

    public function create($data)
    {
        $result = $this->model->create($data);
        $this->removeCache();
        return $result;
    }

    public function whereByUpdate($key,$value,$data)
    {
        $result = $this->model->where($key,$value)->update($data);
        $this->removeCache();
        return $result;
    }

    public function cache()
    {
        if(Cache::has('program')){
            return Cache::get('program');
        }
        return Cache::rememberForever('program',function (){
            return \DB::table($this->model->getTable())->orderBy('sort','asc')->get();
        });
    }

    protected function removeCache()
    {
        if(Cache::has('program')){
            Cache::forget('program');
        }
    }

}