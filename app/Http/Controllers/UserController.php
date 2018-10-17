<?php

namespace App\Http\Controllers;

use App\Repositories\CollectRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Vinkla\Hashids\Facades\Hashids;

class UserController extends Controller
{
    public function index()
    {
        $userInfoMenu = 'active';
        return view('home.user.info',compact(['userInfoMenu']));
    }

    public function collectVideo()
    {
        $collectMenu = 'active';

        $video = (new UserRepository())->collectOrderByPaginate();
        $imgServer = $this->imgServer();

        return view('home.user.collect',compact(['collectMenu','video','imgServer']));
    }

    public function removeCollect($token)
    {

        Validator::make(['token' => $token],[
            'token' => 'required|size:15'
        ],[
            'token.required' => 'token不能為空',
            'token.size' => '請輸入合法的token'
        ])->validate();

        $collectRepository = new CollectRepository();

        $collect = $collectRepository->whereFirst(
            Hashids::decode($token),
            Auth::id()
        );

        if(empty($collect)){
            return $this->msgJson(404,'請選擇！',404);
        }

        if($collectRepository->destroy($collect)){
            return $this->msgJson(0,'刪除成功');
        }
        Log::alert('用戶移除收藏影片出錯');
        return $this->msgJson(500,'請刷新嘗試！',500);
    }

    public function updateUserName(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ],[
            'username.required' => '用戶名不能為空',
            'password.required' => '密碼不能為空'
        ]);

        $data['name'] = Auth::user()->name;
        $data['password'] = $request->get('password');
        $name = $request->get('username');

        if(!Auth::attempt($data)){
            return $this->msgJson(403,'密碼錯誤！',403);
        }

        if((new UserRepository())->whereUpdate(['name' => $name])){
            return $this->msgJson(0,'修改成功！');
        }

        return $this->msgJson(500,'修改失敗',500);

    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'oldpassword' => 'required',
            'password' => 'required|confirmed'
        ],[
            'oldpassword.required' => '當前密碼不能為空！',
            'password.required' => '新密碼不能為空',
            'password.confirmed' => '兩次密碼不一致'
        ]);

        $data['password'] = $request->get('oldpassword');
        $password = $request->get('password');
        $data['name'] = Auth::user()->name;

        if(!Auth::attempt($data)){
            return $this->msgJson(403,'密碼不正確',403);
        }

        if((new UserRepository())->updatePassword($password)){
            return $this->msgJson(0,'修改成功！');
        }

        return $this->msgJson(500,'修改失敗！',500);

    }
}
