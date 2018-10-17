@extends('mobile.layouts.app')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/video.js@7.1.0/dist/video-js.min.css" integrity="sha256-r3wnshnvHEuOZyvzzh9PGSI1v4O42BxExVoKBvP5xzY=" crossorigin="anonymous">
@stop

@section('content')
    <div class="row video-paly">
        <!-- play -->
        <div class="col-100">
            <video id="my-video" class="video-js vjs-big-play-centered" controls preload="auto" width="100%" height="250" poster="{{ $imgServer . $video->thumbnail }}" data-setup='{"controls":true,"loop":false,"bigPlayButton":true,"textTrackDisplay":true,"errorDisplay":false,"control":{"captionsButton":false,"chaptersButton":false,"liveDisplay":false,"playbackRateMenuButton":false,"subtitlesButton":false},"controlBar":{"muteToggle":false,"captionsButton":false,"chaptersButton":false,"playbackRateMenuButton":true,"LiveDisplay":false,"subtitlesButton":false,"remainingTimeDisplay":true,"progressControl":true,"volumeMenuButton":{"inline":false,"vertical":true}}}'>
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
            <div class="row bg-color-white text-color-gray" style="font-size: 11px;padding: 8px 4px;">
                <div class="col-25">
                    <i class="f7-icons diy-size-20">today_fill</i>
                    {{ $video->updated_at->format('Y/m/d') }}
                </div>
                <div class="col-25">
                    <i class="f7-icons diy-size-20">eye_fill</i>
                    {{ $video->view + $video->click }}
                </div>
                <div class="col-25 collect-put">
                    <i class="f7-icons diy-size-20"> @if($video->is_collect == null)bookmark @else bookmark_fill @endif</i>
                    <span>@if($video->is_collect == null)收藏@else取消收藏@endif</span>
                </div>
                <div class="col-25 put-video-reflect">
                    <i class="f7-icons diy-size-20">bell_fill</i>
                    檢舉
                </div>
            </div>
        </div>
        <!-- end play -->
        @if($video->is_vip == 1 && $isVip == false)
        <div class="col-100 line-height-3 margin-top-03 bg-color-blue text-color-white">
            <div class="row">
                <div class="col-65 left" style="text-align: center;">
                    此片為VIP影片，您可以預覽60秒！
                </div>
                <div class="col-35 right">
                    <button class="col button button-big button-raised button-fill color-green letter-spacing-4 play-video">購買</button>
                </div>
            </div>
        </div>
        @endif
        <div class="col-100 bg-color-white margin-top-05" style="padding: 10px 0px 10px 11px;">
            <div class="col-100"> <i class="f7-icons diy-size-20 text-color-blue margin-right-03">data_fill</i>
                <span class="font-weight">伺服器</span>
                <em style="font-size: 11px;" class="text-color-gray">如發現卡頓，請嘗試其他伺服器！</em>
            </div>
        </div>
        <div class="col-100 list server" style="margin-top: 0px;margin-bottom:0px;">
            <ul>
                <li style="padding-top: 4px;">
                    <div class="item-link item-content">
                        <div class="item-cell">

                            <div class="item-row padding-right-03">
                            @foreach($server as $key=>$value)
                                <div class="item-cell put-reset-server" data-token="{{ Hashids::encode($value['id']) }}">
                                    <button class="col button button-fill">{{ $value['name'] }}</button>
                                </div>
                            @if(($key+1)%3 == 0)
                            </div>
                            <div class="item-row padding-right-03">
                            @endif
                            @endforeach

                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <div class="col-100 bg-color-white" style="margin-top: 12px;padding: 10px;">
            <span class="text-color-blue font-weight">標題：</span>{{ $video->name }}
        </div>
    </div>
    <!-- end video -->
    <div class="row video-line margin-top-05">
        <div class="col-100">隨機推薦</div>
    </div>

    <div class="row video-rand">
        <!-- video -->

    </div>
@stop

@section('script')
            <script src="https://cdn.jsdelivr.net/npm/video.js@7.1.0/dist/video.min.js" integrity="sha256-ghYW+EJL1f99ECDJ7QcivpilafSvpQmoYM4Whm4hd74=" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/videojs-contrib-hls@5.14.1/dist/videojs-contrib-hls.min.js" integrity="sha256-ngHSRzCW6euvtJPYDc6HnWd9UvS7VxXfOcRt5Kt0ZrA=" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/videojs-watermark@2.0.0/dist/videojs-watermark.min.js" integrity="sha256-lMN3bfacEnJYlL4VaDBcgAZ+razfu/gfJ6FfrX4Oj+U=" crossorigin="anonymous"></script>
    <script>
        let isLogin = @if(Auth::check()) true @else false @endif;
        let imgServer = "{{ $imgServer }}";
        let videoToken = "{{ Hashids::encode($video->id) }}";
        videoInt('');

        window.onload = function(){
            myApp.request.post('/rand-video',{name: "John", time: "2pm"},function (e) {
                $$(".video-rand").html(videoListMart(e.data,imgServer));
            },function (xhr) {},'json');
        }

        $$(".play-video").on('click',function () {
            myApp.preloader.show();
            if(isLogin == false){
                myApp.preloader.hide();
                myApp.dialog.alert('您還沒登陸，請先登陸！');
                return false;
            }
            if(videoToken == ''){
                myApp.preloader.hide();
                myApp.dialog.alert('請選擇視頻');
                return false;
            }
            myApp.request.post('/member/pay-video',{token:videoToken},function (e) {
                myApp.preloader.hide();
                notifications('購買視頻',e.message).open();
                setInterval(function () {

                },3000);
                window.location.reload();
            },function (xhr) {
                myApp.preloader.hide();
                myApp.dialog.alert(errorJsonToText( JSON.parse(xhr.response)));
            },'json');
        });

        $$(".put-reset-server").on('click',function () {
            myApp.preloader.show();
            let token = $$(this).data('token');
            if(token == ''){
                myApp.preloader.hide();
                myApp.dialog.alert('請選擇伺服器');
                return false;
            }
            myApp.request.post('/change-server',{token:token},function (e) {
                myApp.preloader.hide();
                changServer(e.data.link);
                toastConter(e.message).open();
            },function (xhr) {
                myApp.preloader.hide();
                myApp.dialog.alert(errorJsonToText( JSON.parse(xhr.response)));
            },'json');
        });

        $$(".collect-put").on('click',function () {
            myApp.preloader.show();
            let _this = $$(this);

            if(isLogin == false){
                myApp.preloader.hide();
                myApp.dialog.alert('您還沒登陸，請先登陸！');
                return false;
            }

            if(videoToken == ''){
                myApp.preloader.hide();
                myApp.dialog.alert('請選擇視頻！');
                return false;
            }

            myApp.request.post('/member/collect',{token:videoToken},function (e) {
                myApp.preloader.hide();
                status_text = '收藏';
                if(e.code == 2){
                    status_text = '取消收藏';
                    _this.find('i').text('bookmark_fill');
                }else{
                    _this.find('i').text('bookmark');
                }
               _this.find('span').text(status_text);
                toastConter(e.message).open();
            },function (xhr) {
                myApp.preloader.hide();
                myApp.dialog.alert(errorJsonToText( JSON.parse(xhr.response)));
            },'json');
        });

        $$(".put-video-reflect").on('click',function () {
            myApp.preloader.show();

            if(isLogin == false){
                myApp.preloader.hide();
                myApp.dialog.alert('您還沒登陸，請先登陸！');
                return false;
            }

            if(videoToken == ''){
                myApp.preloader.hide();
                myApp.dialog.alert('請選擇視頻');
                return false;
            }
            myApp.request.post('/member/reflect',{token:videoToken},function (e) {
                myApp.preloader.hide();
                toastConter(e.message).open();
            },function (xhr) {
                myApp.preloader.hide();
                myApp.dialog.alert(errorJsonToText( JSON.parse(xhr.response)));
            },'json');
        });

        function changServer(server) {
            let videoLink = $$(".vjs-tech source").attr('src');
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
    </script>
@stop