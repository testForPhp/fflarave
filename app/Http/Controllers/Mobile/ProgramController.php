<?php
namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Repositories\ProgramRepository;

class ProgramController extends Controller
{
    public function index()
    {
        $program = (new ProgramRepository())->whereOrderByGet();
        $webname = '會員套餐';
        return view('mobile.program.index',compact(['program','webname']));
    }
}