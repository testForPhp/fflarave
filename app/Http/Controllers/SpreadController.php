<?php
namespace App\Http\Controllers;

use App\Repositories\UserSpreadRepository;
use Illuminate\Http\Request;

class SpreadController extends Controller
{
    public function index(Request $request)
    {

        if($request->has('token')){
            (new UserSpreadRepository())->isSource($request);
        }
        return redirect('/');
    }
}