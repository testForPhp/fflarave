<?php
namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Repositories\SortRepository;
use App\Repositories\VideoRepository;
use App\Transformers\VideoTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;

class IndexController extends Controller
{
    protected $videoRepository;

    public function __construct(VideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }
    
    public function index()
    {
        $banner = $this->videoRepository->banner();
        $imgServer = $this->imgServer();
        return view('mobile.index.index',compact(['banner','imgServer']));
    }

    public function islogin()
    {
        if(Auth::check()){
            return redirect('/mobile/member.index');
        }
        return redirect('/mobile/login');
    }
    
    public function listVideo(Request $request, $token)
    {

        $page = 1;
        $limit = 16;

        if($request->has('page')){
            $page = $request->get('page');
        }

        $offset = ($page - 1) * $limit;

        $sortModel = (new SortRepository());

        $sort_id = Hashids::decode($token);

        $sort = $sortModel->SortListPage($sort_id,$offset,$limit);
        $sortName= $sortModel->whereFirst(['id'=>$sort_id]);

        if($sort == false){
            return redirect('/mobile/index');
        }
        $sort['limit'] = $limit;
        $sort['token'] = $token;
        $imgServer = $this->imgServer();
        $webname = $sortName->name;

        return view(
            'mobile.index.list',
            compact(['sort','page','imgServer','webname'])
        );
    }
    
    public function newVideo()
    {
        $host = $this->videoRepository->newVideo();
        $video = (new VideoTransformer())->collect($host);
        return $this->msgJson(0,'success',200,$video);
    }
}