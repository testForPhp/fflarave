<?php
namespace App\Http\Controllers\Mobile\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function index()
    {

        return view('mobile.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $email = $request->get('email');
        $password = $request->get('password');

        if(Auth::attempt(['email' => $email,'password' => $password])){
            return $this->msgJson(0,'登陸成功！',200,['url'=>'/mobile/member/']);
        }
        return $this->msgJson(400,'郵箱或密碼錯誤！',400);
    }

    public function logout(Request $request)
    {
        Auth::guard()->logout();
        $request->session()->invalidate();
        return redirect('/mobile/index');
    }
}