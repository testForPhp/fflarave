<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected $webPath = '/master/admin';

    public $menuActive;


    public function __construct()
    {
        \View::share('menuActive',[$this->menuActive => 'active']);
        \View::share('webPath',$this->webPath);
    }


}