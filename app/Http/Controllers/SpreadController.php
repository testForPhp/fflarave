<?php
namespace App\Http\Controllers;

use App\Repositories\UserSpreadRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpreadController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::check()){
            return false;
        }
        if($request->has('token')){
            (new UserSpreadRepository())->isSource($request);
        }
        return redirect('/');
    }
}