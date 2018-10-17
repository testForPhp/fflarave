<?php

namespace App\Http\Controllers\Admin;

use App\Models\SystemServer;
use App\Repositories\ServerRepository;
use Illuminate\Http\Request;

class ServerController extends BaseController
{

    public $menuActive = 'system';
    protected $serverRepository;

    public function __construct(ServerRepository $serverRepository)
    {
        $this->serverRepository = $serverRepository;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $serverMenu = 'active';
        $servers = $this->serverRepository->whereOrderByPaginate();
        return view('admin.system.server',compact(['serverMenu','servers']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $serverMenu = 'active';
        return view('admin.system.create_and_edit_server',compact('serverMenu'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'site' => 'required|url'
        ]);
        $data = $request->only(['name','site']);
        $data['is_active'] = $request->has('is_active') ? $request->get('is_active') : 0;
        $id = $request->get('id');

        if($id){
            $result = $this->serverRepository->whereUpdate(['id'=>$id],$data);
        }else{
            $result = $this->serverRepository->create($data);
        }

        if($result){
            return redirect($this->webPath . '/system/server');
        }
        return redirect()->back()->withErrors('提交失败！');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $serverMenu = 'active';
        $server = $this->serverRepository->whereFirst(['id'=>$id]);
        if(empty($server)){
            return redirect()->back();
        }
        return view('admin.system.create_and_edit_server',compact(['serverMenu','server']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(empty($id)){
            return $this->msgJson(404,'请选择',403);
        }

        $server = $this->serverRepository->whereFirst(['id'=>$id]);

        if(empty($server)){
            return $this->msgJson(404,'不存在！',404);
        }

        if($this->serverRepository->destroy($server)){
            return $this->msgJson(0,'success');
        }

        return $this->msgJson('500','error',500);
    }
}
