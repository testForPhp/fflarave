<?php
namespace App\Transformers;

use App\Repositories\SystemRepository;
use Vinkla\Hashids\Facades\Hashids;

class VideoTransformer extends BaseTransformer
{
    public function transformer($item)
    {
        return [
            'title' => $item['name'],
            'date' => $item['updated_at'],
            'time_limit' => $item['time_limit'],
            'view' => $item['view'] + $item['click'],
            'pie' => $item['pixel'],
            'thumb' => $this->imgServer() . $item['thumbnail'],
            'token' => Hashids::encode($item['id'])
        ];
    }

    public function collect($items)
    {
        $data = array();
        foreach ($items as $key=>$val){
            $data[$key]['title'] = $val->name;
            $data[$key]['time'] = $val->updated_at->format('Y-m-d');
            $data[$key]['limit'] = $val->time_limit;
            $data[$key]['view'] = ($val->view + $val->click);
            $data[$key]['pixel'] = $val->pointData()[$val->pixel];
            $data[$key]['thumb'] =  $this->imgServer() . $val->thumbnail;
            $data[$key]['token'] =  Hashids::encode($val->id);
        }
        return $data;
    }

    private function imgServer()
    {
        $system = (new SystemRepository())->checkCache();

        if(empty($system)){
            return false;
        }
        return $system->imgServer;
    }
}