<?php
namespace App\Http\Controllers\Mobile\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function index()
    {
        return view('mobile.auth.forgot');
    }

    public function sendRestPasswordEmail(Request $request)
    {
        $request->validate(['email'=>'required|email']);

        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $this->msgJson(0,trans($response));

    }
}