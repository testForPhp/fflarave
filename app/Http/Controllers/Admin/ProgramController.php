<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\ProgramRepository;
use Illuminate\Http\Request;

class ProgramController extends BaseController
{
    public $menuActive = 'finance';

    public $programRepository;

    public function __construct(ProgramRepository $programRepository)
    {
        $this->programRepository = $programRepository;
        parent::__construct();
    }

    public function index()
    {
        $program = $this->programRepository->orderByPaginate('sort');
        $programMenu = 'active';
        return view('admin.program.index',compact(['program','programMenu']));
    }

    public function create()
    {
        $programMenu = 'active';
        return view('admin.program.create',compact(['programMenu']));
    }

    public function edit($id)
    {
        $info = $this->programRepository->find($id);

        if(empty($info)){
            return redirect()->back();
        }

        $programMenu = 'active';
        return view('admin.program.create',compact(['programMenu','info']));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'summary' => 'required',
            'time' => 'required',
            'total' => 'required'
        ]);

        $data = $request->only(['title','summary','time','total','sort','sales']);
        $id = $request->get('id');

        if($id){
            $result = $this->programRepository->whereByUpdate('id',$id,$data);
        }else{
            $result = $this->programRepository->create($data);
        }

        if($result){
            return redirect($this->webPath . '/program');
        }
        return redirect()->back()->withErrors('提交失敗');
    }

    public function destroy($id)
    {
        $program = $this->programRepository->find($id);

        if(empty($program)){
            return $this->msgJson(404,'方案不存在',404);
        }

        if($this->programRepository->destroy($program)){
            return $this->msgJson(0,'刪除成功');
        }
        return $this->msgJson(500,'刪除失敗',500);
    }
    
}
