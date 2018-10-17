@extends('home.layouts.common')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/video.js@7.1.0/dist/video-js.min.css" integrity="sha256-r3wnshnvHEuOZyvzzh9PGSI1v4O42BxExVoKBvP5xzY=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/videojs-watermark@2.0.0/dist/videojs-watermark.css">
@stop
@section('content')
    <div class="container-fluid mt-3">
        <div class="row mb-4">
            <div class="col-lg-8">
                <ul class="list-group">
                    <li class="list-group-item rounded-0">
                        <h5 class="text-truncate">{{ $video->name }}</h5>
                    </li>
                    <li class="list-group-item rounded-0 p-0">
                        <!-- video -->
                        <video id="my-video" class="video-js vjs-big-play-centered" controls preload="auto" width="300" height="450" poster="{{ $imgServer . $video->thumbnail }}" data-setup='{"controls":true,"loop":false,"bigPlayButton":true,"textTrackDisplay":true,"errorDisplay":false,"control":{"captionsButton":false,"chaptersButton":false,"liveDisplay":false,"playbackRateMenuButton":false,"subtitlesButton":false},"controlBar":{"muteToggle":false,"captionsButton":false,"chaptersButton":false,"playbackRateMenuButton":true,"LiveDisplay":false,"subtitlesButton":false,"remainingTimeDisplay":true,"progressControl":true,"volumeMenuButton":{"inline":false,"vertical":true}}}'>
                            @if($video->is_vip)
                                @if($isVip == false)
                            <source src="{{ $defaultServer }}preview/{{ $video->preview }}" type='application/x-mpegURL'>
                                    @else
                                    <source src="{{ $defaultServer }}{{ $video->link }}" type='application/x-mpegURL'>
                                @endif
                            @else
                                <source src="{{ $defaultServer }}{{ $video->link }}" type='application/x-mpegURL'>
                            @endif
                            <p class="vjs-no-js">
                                To view this video please enable JavaScript, and consider upgrading to a web browser that
                                <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                            </p>
                        </video>
                        <!-- end video -->
                    </li>
                    <li class="list-group-item bg-secondary text-white tool-share">
                    <span class="float-left mr-3">
                      <span class="oi oi-calendar"></span>
                      {{ $video->updated_at->format('Y-m-d') }}
                    </span>
                        <span class="float-left">
                      <span class="oi oi-eye"></span>
                      {{ $video->view + $video->click }}
                    </span>
                        <span class="float-right">
                      <!-- AddToAny BEGIN -->
                      <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                      <a class="a2a_button_twitter"></a>
                      <a class="a2a_button_google_plus"></a>
                      <a class="a2a_button_wechat"></a>
                      <a class="a2a_button_email"></a>
                      <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
                      </div>
                      <script async src="https://static.addtoany.com/menu/page.js"></script>
                            <!-- AddToAny END -->
                    </span>
                        <span class="float-right mr-3 put-video-reflect" data-token="{{ Hashids::encode($video->id) }}">
                      <span class="oi oi-warning"></span>
                      檢舉
                    </span>
                        <span class="float-right mr-3 put-video-collect @if($video->is_collect != null)text-success @endif" data-token="{{ Hashids::encode($video->id) }}">
                      <span class="oi oi-heart"></span>
                      <span class="collect-text">@if($video->is_collect == null)收藏@else取消收藏@endif</span>
                    </span>
                    </li>
                </ul>
                @if($video->is_vip == 1 && $isVip == false)
                <div class="alert alert-danger mt-2" role="alert">
                    此片為VIP影片，您可以預覽60秒，購買後您可以觀看整片！請在右邊側欄點擊"BUY"購買！
                </div>
                @endif
                <ul class="list-group mt-2">
                    <li class="list-group-item rounded-0">
                        線路選擇：
                        @foreach($server as $val)
                        <span class="badge badge-primary p-2 change-server pointer" data-token="{{ Hashids::encode($val['id']) }}">{{ $val['name'] }}</span>
                        @endforeach
                    </li>
                </ul>
            </div>
            <div class="col-lg-4">
                @if($video->is_vip == 1 && $isVip == false)
                <div class="row mb-2">
                    <div class="col-lg-9 pt-4 pb-3 text-secondary border border-primary">
                        <h5>本片计次收看{{ $video->point }}点</h5>
                        <p class="text-primary">购买后48小时内可重覆观看</p>
                    </div>
                    <button class="col-lg-2 bg-primary pt-3 pb-3 text-white text-center border border-primary pointer pay-video-put" data-token="{{ Hashids::encode($video->id) }}">
                        BUY
                    </button>
                    <div class="col-lg-1"></div>
                </div>
                @endif
                @foreach($program as $val)
                <div class="row mb-2">
                    <div class="col-lg-9 pt-4 pb-3 text-secondary border border-primary">
                        <h5>{{ $val->title }}
                           @if($val->sales == 0)
                               {{ $val->total }}
                            @else
                                {{ $val->sales }}
                            @endif
                            点(1元=10點)
                        </h5>
                        <p class="text-primary">{{ $val->summary }}</p>
                    </div>
                    <button class="col-lg-2 bg-primary pt-4 pb-3 text-white text-center border border-primary pointer put-program-buy" data-token="{{ Hashids::encode($val->id) }}">
                        BUY
                    </button>
                    <div class="col-lg-1"></div>
                </div>
                @endforeach
            </div>
        </div>
        <nav aria-label="sub-nav">
            <ul class="list-group">
                <li class="list-group-item border-top-0 border-right-0 border-left-0 rounded-0">
                    <span class="inline-block" style="font-size: 18px;"><span class="oi oi-list text-primary mr-2"></span>相關視頻</span>
                </li>
            </ul>
        </nav>
        <div class="row mt-3 rand-video">
        </div>

    </div>
@stop
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/video.js@7.1.0/dist/video.min.js" integrity="sha256-ghYW+EJL1f99ECDJ7QcivpilafSvpQmoYM4Whm4hd74=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/videojs-contrib-hls@5.14.1/dist/videojs-contrib-hls.min.js" integrity="sha256-ngHSRzCW6euvtJPYDc6HnWd9UvS7VxXfOcRt5Kt0ZrA=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/videojs-watermark@2.0.0/dist/videojs-watermark.min.js" integrity="sha256-lMN3bfacEnJYlL4VaDBcgAZ+razfu/gfJ6FfrX4Oj+U=" crossorigin="anonymous"></script>

    <script>
        let isLogin = @if(Auth::check()) true @else false @endif;
        let imgServer = "{{ $imgServer }}";
        videoInt('');
        $(".put-video-collect").click(function () {
            _this = $(this);
            token = $(this).data('token');
            checkToken(token);
            if(isLogin == false){
                errorMsg('您還沒登陸，請先登陸！');
                return false;
            }
            $.post("/member/collect", { token: token},function(data){
                      status_text = '收藏';
                      if(data.code == 2){
                        status_text = '取消收藏';
                        _this.addClass('text-success');
                      }else{
                          _this.removeClass('text-success')
                      }
                      $(".collect-text").text(status_text);
                      successMsg(data.message);
                     })
                .fail(function (xhr) {
                    errorHtmlMsg(jsonsMsg(xhr))
                });
        });
        $(".put-video-reflect").click(function () {
            token = $(this).data('token');
            checkToken(token);
            if(isLogin == false){
                errorMsg('您還沒登陸，請先登陸！');
                return false;
            }
            $.post("/member/reflect", { token: token},function(data){
                      successMsg(data.message);
                     })
                .fail(function (xhr) {
                    errorHtmlMsg(jsonsMsg(xhr));
                });
        });
        $(".change-server").click(function () {
            let token = $(this).data('token');
            checkToken(token);
            $.post("/change-server", { token: token },function(data){
                changServer(data.data.link);
                successMsg(data.message);
                     })
                .fail(function (xhr) {
                    errorHtmlMsg(jsonsMsg(xhr))
                });
        });
        $(".put-program-buy").click(function () {
            let token = $(this).data('token');

            if(isLogin == false){
                errorMsg('您尚未登陸，請先登陸！');
                return false;
            }

            if(token == '' || token.length < 15){
                errorMsg('請選擇觀看方案');
                return false;
            }
            $.post("/member/program", { token: token },function(data){
                locationReload();
            })
                .fail(function (xhr) {
                    errorMsg(jsonsMsg(xhr));
                });
        });
        $(".pay-video-put").click(function () {
            token = $(this).data('token');
            checkToken(token);
            if(isLogin == false){
                errorMsg('您尚未登陸，請先登陸！');
                return false;
            }
            $.post("/member/pay-video", { token: token },function(data){
                     locationReload();
                     })
                .fail(function (xhr) {
                    errorHtmlMsg(jsonsMsg(xhr));
                });
        });
        window.onload = function () {
            $.post("/rand-video", { name: "John", time: "2pm" },function(data){
                      $(".rand-video").html(randHrml(data.data));
                     });
        };
        function randHrml(data) {
            _html = '';
            $.each(data,function (key,val) {
                _html += '<div class="col-lg-3 mb-3"><div class="card"><a href="/v/'+ val.token +'" class="card-img"><img class="card-img-top" src="'+ imgServer + val.thumb +'" alt="'+ val.title +'"><span class="badge badge-secondary position-absolute">'+ val.limit +'</span></a><div class="card-body p-2"><a href="/v/'+ val.token +'"><h6 class="card-title mb-0 text-dark text-truncate">'+ val.title +'</h6></a></div><div class="card-footer"><small class="text-muted"><span class="float-left"><span class="oi oi-clock mr-1"></span>'+ val.time +'</span><span class="float-right"><span class="oi oi-eye"></span>'+ val.view +'</span></small></div></div></div>';
            });
            return _html;
        }
        function locationReload() {
            swal({
                title: '購買成功',
                text: '',
                type: 'success',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '確認',
            }).then(function(){
                window.location.reload();
            })
        }
        function changServer(server) {
            let videoLink = $(".vjs-tech source").attr('src');
            if(videoLink == ''){
                return null;
            }
            httpurl = videoLink.split("//");
            videoUrl = httpurl[1].substring(httpurl[1].indexOf('/') + 1);
            videoInt(server + videoUrl);
        }
        function videoInt(server) {
            let myvideo = videojs("#my-video");
            myvideo.watermark({
                image:'https://ae01.alicdn.com/kf/HTB1p7ydXzzuK1Rjy0Fp761EpFXaU.png',
                url:'http://www.japanxav.com'
            });
            if(server != ''){
                myvideo.src(server);
                myvideo.load();
            }
        }
        function checkToken(token) {

            if(token == '' || token.length < 15){
                errorMsg('請選擇！');
                return false;
            }
            return false;
        }
    </script>
@stop