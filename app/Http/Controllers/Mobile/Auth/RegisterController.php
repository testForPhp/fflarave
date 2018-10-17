<?php
namespace App\Http\Controllers\Mobile\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index()
    {
        return view('mobile.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $user['name'] = $request->get('name');
        $user['email'] = $request->get('email');
        $user['password'] = bcrypt($request->get('password'));
        $user['device'] = 'mobile';

        $result = (new UserRepository())->create($user);

        if(!$result){
            return $this->msgJson(500,'提交失敗，請返回重試！',500);
        }

        Auth::login($result);
        return $this->msgJson(0,'登陸成功',200,['url'=>'/mobile/member/index']);
    }
}