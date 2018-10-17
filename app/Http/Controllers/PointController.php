<?php

namespace App\Http\Controllers;

use App\Repositories\PayCodeLogRepository;
use App\Repositories\PayCodeRepository;
use App\Repositories\PointRepository;
use App\Repositories\ProgramRepository;
use App\Repositories\UserRepository;
use App\Repositories\VideoPayLogRepository;
use App\Repositories\VideoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Vinkla\Hashids\Facades\Hashids;

class PointController extends Controller
{
    public function index()
    {
        $pointMenu = 'active';
        $point = (new PointRepository())->whereOrderByGet();
        $program = (new ProgramRepository())->whereOrderByGet();

        return view('home.point.index',compact(['pointMenu','point','program']));
    }

    public function pointLog()
    {
        $pointLogMenu = 'active';
        $payLog = (new UserRepository())->payUserLogOrderByPaginate();

        return view('home.point.log',compact(['pointLogMenu','payLog']));
    }

    public function payVideo(Request $request)
    {
        $request->validate([
            'token' => 'required|size:15'
        ],[
            'token.required' => 'token不能為空',
            'token.size' => '請輸入合法的token'
        ]);

        $userRepository = new UserRepository();
        $videoRepository = new VideoRepository();

        $video = $videoRepository->whereFirst([
            'id'=> Hashids::decode($request->get('token'))
        ]);

        if(empty($video)){
            return $this->msgJson(404,'視頻不存在',404);
        }


        if($userRepository->user()->point < $video->point){
            return $this->msgJson(403,'您的點數不夠，請先儲值！',403);
        }

        $result = $userRepository->whereUpdate([
            'point' => $userRepository->user()->point - $video->point
        ]);

        if(!$result){
            Log::alert('用戶購買視頻扣除用戶點數失敗');
            return $this->msgJson(500,'操作失敗，請重施！',500);
        }

        if(
            (new VideoPayLogRepository())->create([
                'user_id'=> $userRepository->user()->id,
                'video_id' => $video->id,
                'point' => $video->point
            ])
        ){
            return $this->msgJson(0,'購買成功！');
        }

        $userRepository->whereUpdate([
            'point' => $userRepository->user()->point + $video->point
        ]);

        Log::alert('用戶購買視頻插入日誌失敗');
        return $this->msgJson(500,'操作失敗，請重試！',500);
    }

    public function activeCode(Request $request)
    {
        $request->validate([
            'code' => 'required|size:6'
        ],[
            'code.required' => '激活不能為空',
            'code.size' => '激活嗎必須為六位字幕加數字',
        ]);
        $code = $request->get('code');
        $result = (new PayCodeRepository())->whereFirst(['code' => $code]);

        if(empty($result)){
            return $this->msgJson(404,'激活嗎不存在',404);
        }

        if($result->status == 1){
            return $this->msgJson(403,'激活嗎已使用！',403);
        }

        $point = $result->point->point + Auth::user()->point;

        if(!(new UserRepository())->whereUpdate(['point' => $point])){
            Log::alert('激活嗎更新用戶表失敗');
            return $this->msgJson(500,'激活失敗,請重施！',500);
        }

        $result->status = 1;
        $result->save();

        $payLog = (new PayCodeLogRepository())->create([
            'user_id' => Auth::id(),
            'code_id' => $result->id,
            'code' => $result->code,
            'money' => $result->point->money,
            'point' => $result->point->point,
            'summary' => $result->point->summary
        ]);

        if($payLog){
            return $this->msgJson(0,'儲值成功，已將點數存入您的帳戶！');
        }

        (new UserRepository())->whereUpdate(['point' => (Auth::user()->point - $result->point->point)]);

        $result->status = 0;
        $result->save();

        Log::alert('激活嗎增加消費日誌失敗');
        return $this->msgJson(500,'激活失敗，請重施！',500);
    }

}
