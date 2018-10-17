<?php
namespace App\Http\Controllers;

use App\Repositories\LinkRepository;
use App\Repositories\SortRepository;
use App\Repositories\VideoRepository;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class HomeController extends Controller
{

    public function index()
    {

        $videoRepository = new VideoRepository();
        $banner = $videoRepository->banner();
        $imgServer = $this->imgServer();
        $sort = (new SortRepository())->home();
        $link = (new LinkRepository())->orderByGet('sort');
        return view('home.index.index',compact(['banner','imgServer','sort','link']));
    }

    
    public function list($id)
    {
        $id = Hashids::decode($id);
        $sort = (new SortRepository())->whereFirst(['id'=>$id]);
        $imgServer = $this->imgServer();
        return view('home.index.list',compact(['sort','imgServer']));
    }

    public function rule()
    {
        return view('home.help.rule');
    }

    public function privacy()
    {
        return view('home.help.privacy');
    }

    public function disclaimer()
    {
        return view('home.help.disclaimer');
    }
    
}
