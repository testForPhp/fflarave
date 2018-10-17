<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class LoginController extends BaseController
{
    public function index()
    {
        return view('admin.login.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|min:4|max:15',
            'password' => 'required|min:6|max:15'
        ]);

        $user = $request->only(['username','password']);

        if(\Auth::guard('admin')->attempt($user)){
            return redirect($this->webPath . '/index');
        }
        return redirect()->back()->withErrors('用户不存在或密码错误！');
    }
}
