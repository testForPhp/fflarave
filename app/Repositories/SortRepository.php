<?php

namespace App\Repositories;

use App\Models\Sort;
use Illuminate\Support\Facades\Cache;
use Vinkla\Hashids\Facades\Hashids;

class SortRepository
{
    protected $model;

    /**
     * SortRepository constructor.
     * @param $model
     */
    public function __construct()
    {
        $this->model = new Sort();
    }

    public function orderByPagGetSort($key, $column = 'ASC')
    {
        return $this->model::orderBy($key,$column)->paginate(20);
    }

    public function byWhereIdUpdate($id, $data)
    {
        $result = $this->model->where('id',$id)->update($data);
        $this->cache();
        return $result;
    }

    public function whereFirst(array $where)
    {
        $query = null;
        foreach ($where as $key=>$val){
            $query = $this->model->where($key,$val);
        }

        return $query->first();
    }
    public function getChild()
    {
        return $this->model->where('father_id','!=',0)->get();
    }
    
    public function create($data)
    {
        $result = $this->model->create($data);
        $this->cache();
        return $result;
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function orderByGet($key, $column = 'ASC')
    {
        return $this->model->orderBy($key,$column)->get();
    }

    public function home()
    {
        return $this->model->where('is_home',1)
            ->where('father_id','!=',0)
            ->orderBy('sort')
            ->get();
    }

    public function SortListPage($sort, $page, $limit = 16)
    {
        $sort = $this->model->where('id',$sort)->first();
        if(empty($sort)){
            return false;
        }
        $video = $sort->videos()->where('status',1);
        $count = $video->count();

        $result = $video->offset($page)->limit($limit)->get(['id','name','pixel','time_limit','thumbnail','link','updated_at','view','click']);
        return compact(['count','result']);
    }
    
    public function whereOrderBy(array $where, $order = 'sort', $sort = 'ASC')
    {
        $query = null;
        foreach ($where as $key=>$val){
            $query = $this->model->where($key,$val);
        }
        return $query->orderBy($order,$sort)->get();
    }

    public function destroy(Sort $sort)
    {

        $result = $sort->delete();
        $this->cache();
        return $result;
    }

    public function getCache()
    {
       if(Cache::has('menu') == false){
           $this->cache();
       }
       return Cache::get('menu');
    }

    public function cache()
    {
        if(Cache::has('menu')){
            Cache::forget('menu');
        }
        return Cache::forever('menu',$this->format());
    }
    
    public function format()
    {
        return $this->allChild($this->whereOrderBy(['is_home' => 1],'sort')->toArray());
    }

    protected function allChild(array $data, $father_id = 0)
    {
        $items = [];

        foreach ($data as $key=>$val){
            if($val['father_id'] == $father_id){
                unset($data[$key]);
                $child = $this->allChild($data,$val['id']);
                if($child){
                    $val['child'] = $child;
                }
                $val['id'] = Hashids::encode($val['id']);
                $items[] = $val;
            }
        }
        return $items;
    }
}