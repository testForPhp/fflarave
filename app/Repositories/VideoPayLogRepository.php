<?php

namespace App\Repositories;

use App\Models\VideoPayLog;

class VideoPayLogRepository
{
    public $model;

    public function __construct()
    {
        $this->model = new VideoPayLog();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }
    
    /**
     * 驗證用戶是否購買影片，
     * @param $videoId
     * @return bool 有效true,
     */
    public function isActive($videoId)
    {
        $userId = (new UserRepository())->user()->id;

        $result = $this->model->where('video_id',$videoId)
            ->where('user_id',$userId)
            ->where('status',0)
            ->first();

        if(empty($result)){
            return false;
        }

      if(date('Y-m-d') > $result->created_at->addDays(2)){
            $result->status = 1;
            $result->save();
            return false;
      }
      return true;
    }


}