<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;


class UserController extends BaseController
{
    public $menuActive = 'user';
    public $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $userListMenu = 'active';
        $user = $this->userRepository->orderByPaginate();
        return view('admin.user.index',compact(['userListMenu','user']));
    }
}
