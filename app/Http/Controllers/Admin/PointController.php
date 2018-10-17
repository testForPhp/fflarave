<?php
namespace App\Http\Controllers\Admin;

use App\Repositories\PointRepository;
use Illuminate\Http\Request;

class PointController extends BaseController
{
    public $menuActive = 'point';
    public $pointRepository;

    public function __construct(PointRepository $pointRepository)
    {
        $this->pointRepository = $pointRepository;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pointMenu = 'active';
        $point = $this->pointRepository->orderByPaginate('sort');
        return view('admin.point.index',compact(['pointMenu','point']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pointMenu = 'active';
        return view('admin.point.create',compact('pointMenu'));
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
            'summary' => 'required',
            'point' => 'required|numeric',
            'money' => 'required',
            'link' => 'required',
        ]);

        $data = $request->only(['title','summary','point','money','link','sort']);

        $id = $request->get('id');

        if($id){
            $result = $this->pointRepository->whereByUpdate('id',$id,$data);
        }else{
            $result = $this->pointRepository->create($data);
        }

        if($result){
            return redirect($this->webPath . '/point');
        }
        return redirect()->back()->withErrors('提交失败');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $info = $this->pointRepository->find($id);

        if(empty($info)){
            return redirect()->back();
        }

        $pointMenu = 'active';
        return view('admin.point.create',compact(['pointMenu','info']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $point = $this->pointRepository->find($id);

        if(empty($point)){
            return $this->msgJson(404,'套餐不存在',404);
        }

        if($this->pointRepository->destroy($point)){
            return $this->msgJson(0,'删除成功');
        }
        return $this->msgJson(500,'删除失败',500);
    }
}
