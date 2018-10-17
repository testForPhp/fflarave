<?php
namespace App\Repositories;

use App\Models\SystemServer;
use Illuminate\Support\Facades\Cache;

class ServerRepository
{
    public $model;

    public function __construct()
    {
        $this->model = new SystemServer();
    }

    public function whereFirst(array $where)
    {
        $query = $this->model;
        foreach ($where as $key=>$value){
            $query = $query->where($key,$value);
        }
        return $query->first();
    }

    public function destroy(SystemServer $server)
    {
        $result = $server->delete();
        $this->cache();
        return $result;
    }

    public function create($data)
    {
        $result = $this->model->create($data);
        $this->cache();
        return $result;
    }
    
    public function whereUpdate(array $where,$data)
    {
        $query = $this->model;
        foreach ($where as $key=>$value){
            $query = $query->where($key,$value);
        }
        $result = $query->update($data);
        $this->cache();
        return $result;
    }

    public function whereOrderByPaginate($where = [], $order = 'id', $sort = 'desc', $limit = 20)
    {
        $query = $this->model;
        if($where){
            foreach ($where as $key=>$val){
                $query = $query->where($key,$val);
            }
        }
        return $query->orderBy($order,$sort)->paginate($limit);
    }

    public function checkCache()
    {
        if(Cache::has('server') == false){
            $this->cache();
        }
        return Cache::get('server');
    }

    protected function cache()
    {
        Cache::forget('server');
        Cache::forever(
            'server',
            $this->model->where('is_active',1)->get()->toArray()
        );
    }

}