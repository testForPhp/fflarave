<?php

namespace App\Repositories;


use App\Models\Video;
use Illuminate\Support\Facades\Cache;

class VideoRepository
{
    public $model;
    /**
     * VideoRepository constructor.
     */
    public function __construct()
    {
        $this->model = new Video();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function whereFirst(array $where)
    {
        $query = $this->model;
        foreach ($where as $key=>$value){
            $query = $query->where($key,$value);
        }

        return $query->first();
    }

    public function banner()
    {
        return $this->model->where('is_banner',1)
            ->where('status',1)
            ->orderBy('id','desc')->limit(5)->get();
    }

    public function newVideo($limit = 8)
    {
        return $this->model->where('status',1)
            ->orderBy('updated_at','desc')
            ->limit($limit)
            ->get();
    }
    
    public function searchPaginate($where, $order = 'id', $sort = 'desc', $limit = 20)
    {
        $query = $this->model;

        foreach ($where as $key=>$value){
            $query = $query->where($key,'like',"%{$value}%");
        }
        return $query->orderBy($order,$sort)->paginate($limit);
    }


    public function whereOrderByGet($where, $order = 'id', $sort = 'ASC')
    {
        $query = null;
        foreach ($where as $key=>$val){
            $query = $this->model->where($key,$val);
        }
        return $query->orderBy($order,$sort)->get();
    }
    
    /**
     * 更新
     * @param $key 條件索引
     * @param $value 條件值
     * @param $data 更新內容
     * @return mixed
     */
    public function update($key,$value,$data)
    {
        $this->clearTotalIdCache();
        return $this->model->where($key,$value)->update($data);
    }
    
    public function create($data)
    {
        $this->clearTotalIdCache();
        return $this->model->create($data);
    }

    /**
     * 根據條件排序進行分頁
     * @param $where 條件
     * @param $order 排序KEY
     * @param string $sort 排序
     * @param int $limit 分頁
     * @return mixed
     */
    public function whereOrderByPaginate(array $where,$order,$sort = 'ASC',$limit = 15)
    {
        $query = null;

        foreach ($where as $key=>$val){
            if($key == 'name' || $key == 'preview'){
                $query = $this->model->where($key,'like',"%{$val}%");
            }else{
                $query = $this->model->where($key,$val);
            }

        }
        return $query->orderBy($order,$sort)->paginate($limit);
    }

    public function destroy(Video $video)
    {
        $this->clearTotalIdCache();
        return $video->delete();
    }
    
    public function point()
    {
        return $this->model->pointData();
    }
    public function city()
    {
        return $this->model->city();
    }


    public function randVideo($limit = 8)
    {
        if(Cache::has('videoIds') == false){
            $this->totalIdCache();
        }
        $ids = Cache::get('videoIds');

        $rand = [];

        foreach (array_rand($ids,$limit) as $val){
            $rand[] = $ids[$val];
        }
       return $this->model->whereIn('id',$rand)->get(['id','name','pixel','time_limit','thumbnail','view','click','updated_at']);
    }

    protected function clearTotalIdCache()
    {
        Cache::forget('videoIds');
    }

    protected function totalIdCache()
    {
        $videos = $this->model->where('status',1)->get(['id']);

        $id = collect($videos)->pluck('id')->toArray();

        return Cache::forever('videoIds',$id);
    }
}