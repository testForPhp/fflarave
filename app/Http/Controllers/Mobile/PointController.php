<?php
namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Repositories\PointRepository;
use App\Repositories\UserRepository;

class PointController extends Controller
{
    public function index()
    {
        $point = (new PointRepository())->whereOrderByGet();
        $webname = '儲值點數';
        return view('mobile.point.index',compact(['point','webname']));
    }

    public function log()
    {
        $log = (new UserRepository())->payUserLogOrderByPaginate();
        $webname = '消費紀錄';
        return view('mobile.point.log',compact(['log','webname']));
    }
}