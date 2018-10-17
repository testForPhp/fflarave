<?php

namespace App\Http\Controllers\Admin;

class HomeController extends BaseController
{
    public $menuActive = 'home';

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('admin.home.index');
    }
}
