<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\TagRepository;
use Illuminate\Http\Request;

class TagsController extends BaseController
{
    public $menuActive = 'videoMenu';

    protected $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        parent::__construct();
        $this->tagRepository = $tagRepository;
    }

    public function index()
    {
        $videoTagMenu = 'active';
        $tags = $this->tagRepository->orderByPaginate('id','desc');
        return view('admin.tag.index',compact(['videoTagMenu','tags']));
    }

    public function edit($id)
    {
        $tag = $this->tagRepository->whereFirst('id',$id);
        if(empty($tag)){
            return $this->msgJson(404,'标签不存在',404);
        }
        return $this->msgJson(0,'success',200,$tag->toArray());
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);
        $title = $request->get('title');
        $tag = $this->tagRepository->whereFirst('title',$title);
        $id = $request->get('id');

        if($tag && empty($id)){
            return $this->msgJson(1,'标签已存在',400);
        }

        if($id){
            $result = $this->tagRepository->whereIdByUpdate($id,['title'=>$title]);
        }else{
            $result = $this->tagRepository->create(['title'=>$title]);
        }

        if($result){
            return $this->msgJson(0,'提交成功');
        }
        return $this->msgJson(500,'提交失败',500);
    }

    public function destroy($id)
    {
        $tag = $this->tagRepository->whereFirst('id',$id);
        if(empty($tag)){
            return $this->msgJson(404,'标签不存在',404);
        }
        if($this->tagRepository->destroy($tag)){
            return $this->msgJson(0,'删除成功');
        }
        return $this->msgJson(500,'删除失败',500);
    }
    
}
