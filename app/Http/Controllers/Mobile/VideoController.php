<?php
namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\Controller;
use App\Repositories\ProgramRepository;
use App\Repositories\ServerRepository;
use App\Repositories\VideoRepository;
use Vinkla\Hashids\Facades\Hashids;

class VideoController extends Controller
{
    public function index($token)
    {
        $video = (new VideoRepository())->whereFirst([
            'id' => Hashids::decode($token),
            'status' => 1
        ]);

        if(empty($video)){
            return redirect()->back();
        }
        $imgServer = $this->imgServer();
        $server = (new ServerRepository())->checkCache();

        $serverModel = new \App\Http\Controllers\VideoController();

        $defaultServer = $serverModel->defaultServer();

        if($defaultServer == false){
            $rand = array_rand($server,1);
            $defaultServer = $serverModel->defaultServer($server[$rand]['site']);
        }

        $video->is_collect = $video->isCollect();

        $isVip = false;
        if($video->is_vip){
            $isVip = $serverModel->isVip($video->id);
        }
        $webname = $video->name;
        $program = (new ProgramRepository())->cache();
        return view('mobile.video.index',compact(['video','imgServer','server','defaultServer','isVip','program','webname']));
    }
}