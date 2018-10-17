<?php
namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Repositories\NotifyRepository;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    public function info()
    {
        $webname = '個人資料';
        return view('mobile.user.info',compact(['webname']));
    }

    public function notice()
    {
        $notice = (new NotifyRepository())->orderByPaginate();
        $webname = '訊息';
        return view('mobile.user.notice',compact(['notice','webname']));
    }

    public function collect()
    {
        $imgServer = $this->imgServer();
        $video = (new UserRepository())->collectOrderByPaginate();
        $webname = '收藏影片';
        return view('mobile.user.collect',compact(['imgServer','video','webname']));
    }
}