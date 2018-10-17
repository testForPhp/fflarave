<?php
/**
 * Created by PhpStorm.
 * User: rookie
 * Date: 2018/9/25
 * Time: 16:13
 */

namespace App\Repositories;


use App\Models\VideoToTag;

class VideoToTagRepository
{
    public $model;
    /**
     * VideoToTagRepository constructor.
     */
    public function __construct()
    {
        $this->model = new VideoToTag();
    }

    public function delete($key,$value)
    {
        return $this->model->where($key,$value)->delete();
    }
    
    public function insert($data)
    {
        return \DB::table($this->model->getTable())->insert($data);
    }
}