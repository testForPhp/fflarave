<?php
namespace App\Http\Controllers;

use App\Repositories\CollectRepository;
use App\Repositories\ProgramRepository;
use App\Repositories\ReflectVideoRepository;
use App\Repositories\ServerRepository;
use App\Repositories\VideoPayLogRepository;
use App\Repositories\VideoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
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

        $defaultServer = $this->defaultServer();

        if($defaultServer == false){
            $rand = array_rand($server,1);
            $defaultServer = $this->defaultServer($server[$rand]['site']);
        }

        $video->is_collect = $video->isCollect();

        $isVip = false;
        if($video->is_vip){
            $isVip = $this->isVip($video->id);
        }

        $program = (new ProgramRepository())->cache();

        return view(
            'home.video.index',
            compact(['video','imgServer','server','defaultServer','isVip','program'])
        );
    }

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');
        $video = null;

        if($keyword){

            $video = (new VideoRepository())->searchPaginate(['name'=>$keyword]);
            $imgServer = $this->imgServer();
        }
        return view('home.index.search',compact(['video','imgServer','keyword']));
    }

    public function randVideo()
    {
        $video = (new VideoRepository())->randVideo();
        $hash = new Hashids();

        $videoFormat = collect($video)->map(function ($item) use($hash){
            $data['token'] = $hash::encode($item->id);
            $data['pixel'] = $item->pointData()[$item->pixel];
            $data['thumb'] = $item->thumbnail;
            $data['limit'] = $item->time_limit;
            $data['title'] = $item->name;
            $data['view'] = $item->view + $item->click;
            $data['time'] = $item->updated_at->format('Y-m-d');
            return $data;
        });
        return $this->msgJson(0,'success',200,$videoFormat->toArray());
    }

    public function collectVideo(Request $request)
    {
        $request->validate([
            'token' => 'required|size:15'
        ],[
            'token.required' => 'Token不能為空',
            'token.size'=>'Token格式不對'
        ]);

        $video = (new VideoRepository())->whereFirst([
            'id' => Hashids::decode($request->get('token'))
        ]);

        if(empty($video)){
            return $this->msgJson(404,'視頻不存在',404);
        }

        $collectRepository = new CollectRepository();

        $collect = $collectRepository->whereFirst($video->id,Auth::id());

        if($collect){
            $result = $collectRepository->destroy($collect);
            $status = 1;
        }else{
            $result = $collectRepository->create([
                'user_id' => Auth::id(),
                'video_id' => $video->id
            ]);
            $status = 2;
        }

        if($result){
            return $this->msgJson($status,'提交成功');
        }
        Log::alert('用戶收藏視頻出錯！');
        return $this->msgJson(500,'提交失敗',500);

    }

    public function reflect(Request $request)
    {
        $request->validate([
            'token' => 'required|size:15'
        ],[
            'token.required' => '請選擇視頻',
            'token.size' => '請選擇視頻'
        ]);

        $video = (new VideoRepository())->whereFirst([
            'id' => Hashids::decode($request->get('token'))
        ]);

        if(empty($video)){
            return $this->msgJson(404,'視頻不存在',404);
        }

        $reflectVideoRepository = new ReflectVideoRepository();

        $reflect = $reflectVideoRepository->whereFirst(Auth::id(),$video->id);

        if(empty($reflect) || date('Y-m-d',time()) > $reflect->created_at->format('Y-m-d')){
            $reflectVideoRepository->create([
                'user_id' => Auth::id(),
                'video_id' => $video->id
            ]);
            return $this->msgJson(0,'感謝您的檢舉！');
        }

        return $this->msgJson(400,'每個視頻每天只可以檢舉一次，感謝您的配合！',400);
    }

    /**
     * 用戶是否對影片有觀看權限
     * @param $videoId
     * @return bool 有權限true
     */
    public function isVip($videoId)
    {
        $user = Auth::user();
        $date = date('Y-m-d');

        if(Auth::check() == false){
            return false;
        }

        if($user->is_vip == 1 && $user->vip_end_time >= $date ){
            return true;
        }

        if($user->is_vip == 1 && $user->vip_end_time < $date){
            $user->is_vip = 0;
            $user->program_id = 0;
            $user->vip_end_time = null;
            $user->save();
        }

        if((new VideoPayLogRepository())->isActive($videoId)){
            return true;
        }

        return false;
    }

    public function defaultServer($server = '')
    {
        $name = 'defaultServer';

        if(empty($server)){

            if(Cookie::get($name) == null){
                Log::alert('服務器緩存為空');
                return false;
            }
            return Cookie::get($name);
        }
        Cookie::queue($name,$server,1440);

        return $server;
    }

}
