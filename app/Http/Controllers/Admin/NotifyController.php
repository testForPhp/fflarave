<?php

namespace App\Http\Controllers\Admin;

use App\Models\Notify;
use Illuminate\Http\Request;

class NotifyController extends BaseController
{
    public $menuActive = 'system';

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifyMenu = 'active';
        $notifys = Notify::orderBy('id','desc')->paginate(20);
        return view('admin.notify.index',compact(['notifyMenu','notifys']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $notifyMenu = 'active';
        return view('admin.notify.create_and_edit',compact('notifyMenu'));
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
            'title' => 'required',
            'content' => 'required'
        ]);
        $data = $request->only(['title','content']);

        $id = $request->get('id');

        $model = new Notify();

        if($id){
            $result = $model->where('id',$id)->update($data);
        }else{
            $result = $model->create($data);
        }

        if($result){
            return redirect($this->webPath . '/system/notify');
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
        $notify = Notify::find($id);
        if(empty($notify)){
            return redirect()->back();
        }
        $notifyMenu = 'active';
        return view('admin.notify.create_and_edit',compact(['notifyMenu','notify']));
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
            return $this->msgJson(404,'请选择',401);
        }

        $notify = Notify::find($id);

        if(empty($notify)){
            return $this->msgJson(404,'通知不存在',404);
        }

        if($notify->delete()){
            return $this->msgJson(0,'success');
        }
        return $this->msgJson(500,'error',500);
    }
}
