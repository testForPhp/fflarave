<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\SystemRepository;
use Illuminate\Http\Request;

class SystemController extends BaseController
{
    public $menuActive = 'system';
    public $systemRepository;

    public function __construct(SystemRepository $systemRepository)
    {
        $this->systemRepository = $systemRepository;
        parent::__construct();
    }


    public function index()
    {
        $settingMenu = 'active';
        $system = $this->systemRepository->first();
        return view('admin.system.index',compact(['settingMenu','system']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'website' => 'required',
            'url' => 'required',
            'imgServer' => 'required'
        ]);
        $data = $request->only(['website','url','email','imgServer','count','logo','ads_1','ads_2','ads_1_link','ads_2_link']);

        $system = $this->systemRepository->first();

        if($system){
            $result = $this->systemRepository->whereUpdate('id',$system->id,$data);
        }else{
            $result = $this->systemRepository->create($data);
        }

        if($result){
            return redirect()->back();
        }

        return redirect()->back()->withErrors('提交失败！');

    }
}
