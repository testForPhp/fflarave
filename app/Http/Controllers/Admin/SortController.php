<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\SortRepository;
use Illuminate\Http\Request;

class SortController extends BaseController
{
    public $menuActive = 'videoMenu';
    protected $sortRepository;

    public function __construct(SortRepository $repository)
    {
        $this->sortRepository = $repository;
        parent::__construct();

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videoSort = 'active';
        $sort = $this->sortRepository->orderByPagGetSort('sort');
        return view('admin.sort.index',compact(['videoSort','sort']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $videoSort = 'active';
        $sortAll = $this->sortRepository->orderByGet('sort');
        return view('admin.sort.add',compact(['videoSort','sortAll']));
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
            'name' => 'required'
        ]);

        $data = $request->only(['name','father_id','sort']);
        $data['is_home'] = $request->has('is_home') ? $request->get('is_home') : 0;

        $id = $request->get('id');

        if($id){
            $result = $this->sortRepository->byWhereIdUpdate($id,$data);
        }else{
            $result = $this->sortRepository->create($data);
        }

        if($result){
            return redirect($this->webPath . '/video/sort');
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
        $sort = $this->sortRepository->find($id);

        if(empty($sort)){
            return redirect()->back();
        }
        $videoSort = 'active';
        $sortAll = $this->sortRepository->orderByGet('sort');
        return view('admin.sort.add',compact(['videoSort','sort','sortAll']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sort = $this->sortRepository->find($id);
        if(empty($sort)){
            return $this->msgJson(404,'分类不存在',404);
        }

        if($this->sortRepository->destroy($sort)){
            return $this->msgJson(0,'删除成功');
        }
        return $this->msgJson(500,'提交失败',500);
    }
}
