<?php

namespace App\Http\Controllers\Admin;


use App\Repositories\ReflectVideoRepository;

class ReflectController extends BaseController
{
    public $menuActive = 'reflect';

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $reflect = (new ReflectVideoRepository())->orderByPaginate();

        return view('admin.reflect.index',compact('reflect'));
    }
}
