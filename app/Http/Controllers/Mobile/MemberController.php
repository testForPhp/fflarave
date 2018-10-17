<?php
namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Repositories\NotifyRepository;

class MemberController extends Controller
{
    public function index()
    {
        $notice = (new NotifyRepository())->whereOrderByLimitGet([],'id','desc',2);
        return view('mobile.member.index',compact(['notice']));
    }
}