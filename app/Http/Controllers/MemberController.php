<?php

namespace App\Http\Controllers;

use App\Repositories\NotifyRepository;
use App\Repositories\ServerRepository;
use App\Repositories\UserRepository;
use App\Transformers\NotifyTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Vinkla\Hashids\Facades\Hashids;

class MemberController extends Controller
{
    protected $userRepository;
    /**
     * MemberController constructor.
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $this->userRepository->checkVipEndDate();
        $notify = (new NotifyRepository())->whereOrderByLimitGet();
        $memberIndexMenu = 'active';
        return view(
            'home.member.index',
            compact(['notify','memberIndexMenu'])
        );
    }

    public function serverApi(Request $request)
    {
        $request->validate([
            'token' => 'required|size:15'
        ],[
            'token.required' => '請選擇視頻',
            'token.size' => '請輸入合法的token'
        ]);

        $server = (new ServerRepository())->whereFirst([
            'id' => Hashids::decode($request->get('token')),
            'is_active' => 1,
        ]);

        if(empty($server)){
            return $this->msgJson(404,'伺服器不存在',404);
        }

       $link = (new VideoController())->defaultServer($server['site']);

        if($link == false){
            Log::alert('用戶切換伺服器失敗');
            return $this->msgJson(500,'獲取伺服器失敗',500);
        }

        return $this->msgJson(0,'切換伺服器成功',200,['link'=>$link]);

    }

    public function notify($id)
    {
        $notify = (new NotifyRepository())->whereFirst([
            'id' => Hashids::decode($id)
        ]);
        if(empty($notify)){
            return $this->msgJson(404,'通知不存在',404);
        }
        return $this->msgJson(
            0,
            'success',
            200,
            (new NotifyTransformer())->transformer($notify)
        );
    }
}
