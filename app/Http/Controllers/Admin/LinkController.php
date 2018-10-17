<?php
namespace App\Http\Controllers\Admin;

use App\Repositories\LinkRepository;
use Illuminate\Http\Request;

class LinkController extends BaseController
{
    public $menuActive = 'links';
    protected $linkRepository;

    public function __construct(LinkRepository $linkRepository)
    {
        $this->linkRepository = $linkRepository;
        parent::__construct();
    }

    public function index()
    {
        $links = $this->linkRepository->orderByPaginate('sort');
        return view('admin.links.index',compact('links'));
    }

    public function show($id)
    {
        $link = $this->linkRepository->find($id);
        if(empty($link)){
            return $this->msgJson(404,'連結不存在',404);
        }
        return $this->msgJson(0,'success',200,$link->toArray());
    }

    public function destroy($id)
    {
        $link = $this->linkRepository->find($id);
        if(empty($link)){
            return $this->msgJson(404,'連結不存在',404);
        }
        if($this->linkRepository->destroy($link)){
            return $this->msgJson(0,'刪除成功');
        }
        return $this->msgJson(500,'刪除失敗',500);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'url' => 'required'
        ],[
            'name.required' => '名稱不能為空',
            'url.required' => '連結不能為空'
        ]);
        $data = $request->only(['name','url','sort']);

        $id = $request->get('id');

        if($id){
            $result = $this->linkRepository->whereUpdate('id',$id,$data);
        }else{
            $result = $this->linkRepository->create($data);
        }

        if($result){
            return $this->msgJson(0,'提交成功');
        }
            return $this->msgJson(500,'提交失敗',500);
    }
}
