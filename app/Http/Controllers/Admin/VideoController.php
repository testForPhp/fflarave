<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\SortRepository;
use App\Repositories\TagRepository;
use App\Repositories\VideoRepository;
use App\Repositories\VideoToTagRepository;
use App\Tools\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends BaseController
{
    public $menuActive = 'videoMenu';
    public $videoRepository;

    public function __construct(VideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status)
    {
        $activeVideoMenu = '';
        $haltVideoMenu = '';

        if($status == 1){
            $activeVideoMenu = 'active';
        }else{
            $haltVideoMenu = 'active';
        }

        $sort = (new SortRepository())->getChild();

        $videos = $this->videoRepository->whereOrderByPaginate(['status'=>$status],'created_at','desc');
        return view('admin.video.index',
            compact(['videos','activeVideoMenu','haltVideoMenu','sort','status'])
        );
    }

    public function search(Request $request)
    {
        $data = $request->only(['sort','name','preview']);
        $data['is_vip'] = $request->has('is_vip') ? $request->get('is_vip') : 0;
        $data['is_banner'] = $request->has('is_banner') ? $request->get('is_banner') : 0;

        if($data['sort'] == 'all'){
            unset($data['sort']);
        }

        $status = $request->get('status');
        $videos = $this->videoRepository->whereOrderByPaginate(array_filter($data),'created_at','desc');

        $sort = (new SortRepository())->getChild();

        return view('admin.video.index', compact(['videos','sort','status']));
    }

    public function importFile()
    {
        $importMenu = 'active';

        return view('admin.video.import',compact('importMenu'));
    }

    protected function openFile( Request $request)
    {
        $file = Storage::putFile('coding',$request->file('coding'));

        if(!$file){
            dd($file);
        }
        $content = explode(PHP_EOL,trim(file_get_contents(storage_path('app').'/'.$file)));

        Storage::delete($file);

        $data = collect($content)->map(function ($val){
            $data = explode('=',$val);
            return [
                'key' => $data[1],
                'val' => $data[0]
            ];
        });

        foreach ($data as $val){
            $this->videoRepository->update('preview',$val['key'],['link'=>$val['val']]);
        }

        return redirect()->back();

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $createVideoMenu = 'active';
        $baseData = $this->createAndEditBase();

        return view('admin.video.add',compact(['createVideoMenu','baseData']));
    }

    protected function createAndEditBase()
    {
        return [
            'city' => $this->videoRepository->city(),
            'pointData' => $this->videoRepository->point(),
            'sort' => (new SortRepository())->getChild(),
            'tags' => (new TagRepository())->orderByGet('id','desc')
        ];
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
            'time_limit' => 'required',
            'link' => 'required',
            'preview' => 'required'
        ],[
            'time_limit.required' => '時長不能為空',
            'link.required' => '視頻地址不能為空',
            'preview.required' => '預覽地址不能為空'
        ]);

        $data = $request->only(['name','pixel','sort','region','time_limit','preview','link','point']);
        $data['is_vip'] = $request->has('is_vip') ? $request->get('is_vip') : 0;
        $data['is_banner'] = $request->has('is_banner') ? $request->get('is_banner') : 0;
        $data['view'] = rand(1000,9999);

        $upload = new Upload();
        $img = $upload->put($request,'thumbnail');

        if($img == false){
            return redirect()->back()->withErrors('封面上傳失敗');
        }

        $data['thumbnail'] = $img;

        $result = $this->videoRepository->create($data);

        if(!isset($result->id)){
            $upload->delete($data['thumbnail']);
            return redirect()->back()->withErrors('提交失敗');
        }

        $tags = collect($request->get('tags'))->crossJoin($result->id)->map(function ($val){
            $data['video_id'] = array_last($val);
            $data['tag_id'] = array_first($val);
            return $data;
        });

        if((new VideoToTagRepository())->insert($tags->toArray())){
            return redirect($this->webPath . '/video/0');
        }
        $upload->delete($data['thumbnail']);
        $this->videoRepository->destroy($result);

        return redirect()->back()->withErrors('提交失敗');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $video = $this->videoRepository->find($id);

        if(empty($video)){
            return redirect()->back();
        }

        $createVideoMenu = 'active';
        $baseData = $this->createAndEditBase();

        $tagIds = collect($video->tags)->pluck('id')->toArray();
        $jump = $_SERVER["HTTP_REFERER"];

        return view('admin.video.edit',compact(['createVideoMenu','baseData','video','tagIds','jump']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'time_limit' => 'required',
            'link' => 'required',
            'preview' => 'required',
            'id' => 'required'
        ],[
            'time_limit.required' => '時長不能為空',
            'link.required' => '視頻地址不能為空',
            'preview.required' => '預覽地址不能為空'
        ]);

        $data = $request->only(['name','pixel','sort','region','time_limit','preview','link','point']);
        $data['is_vip'] = $request->has('is_vip') ? $request->get('is_vip') : 0;
        $data['is_banner'] = $request->has('is_banner') ? $request->get('is_banner') : 0;

        $upload = new Upload();
        $img = $upload->put($request,'thumbnail');

        if($img){
            $data['thumbnail'] = $img;
        }

        $id = $request->get('id');

        $result = $this->videoRepository->update('id',$id,$data);

        if(!$result){
            $upload->delete($data['thumbnail']);
            return redirect()->back()->withErrors('提交失敗');
        }

        $VideoToTagRepository = new VideoToTagRepository();

        $VideoToTagRepository->delete('video_id',$id);

        $tags = collect($request->get('tags'))->crossJoin($id)->map(function ($val){
            $data['video_id'] = array_last($val);
            $data['tag_id'] = array_first($val);
            return $data;
        });
        $jump = $request->get('jump');
        if($VideoToTagRepository->insert($tags->toArray())){
            return redirect( $jump ? $jump : '/video/0');
        }
        $upload->delete($data['thumbnail']);
        $this->videoRepository->destroy($result);

        return redirect()->back()->withErrors('提交失敗');
    }

    public function updateStatus(Request $request)
    {
        if(!$request->has('id')){
            return $this->msgJson(400,'無效請求',400);
        }
        $id = $request->get('id');

        $video = $this->videoRepository->find($id);

        if(empty($video)){
            return $this->msgJson(404,'視頻不存在',404);
        }

        $status = 1;

        if($video->status == 1){
            $status = 0;
        }

        if($this->videoRepository->update('id',$id,['status' => $status])){
            return $this->msgJson(0,'提交成功');
        }
        return $this->msgJson(500,'請求失敗',500);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $video = $this->videoRepository->find($id);
        if(empty($video)){
            return $this->msgJson(404,'視頻不存在',404);
        }
        if($this->videoRepository->destroy($video)){
            return $this->msgJson(0,'刪除成功');
        }
        return $this->msgJson(500,'提交失敗',500);
    }
}
