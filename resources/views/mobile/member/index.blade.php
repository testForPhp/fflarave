@extends('mobile.layouts.app')
@section('content')
    <style type="text/css">
        .md .navbar:after,.ios .navbar:after{
            height:0px;
        }
        .md .list ul:before,.ios .list ul:before{
            height: 0px;
        }
    </style>
    <!-- video -->
    <div class="row me" style="">
        <div class="col-100 list media-list bg-color-blue" style="margin-top:0px;margin-bottom: .8em;">
            <ul>
                <li>
                    <div class="item-content bg-color-blue padding-top-10-px padding-bottom-10-px text-color-white">
                        <div class="item-media">
                            <img src="https://b-ssl.duitang.com/uploads/item/201603/14/20160314183826_XtNYf.thumb.700_0.jpeg" width="44"/></div>
                        <div class="item-inner">
                            <div class="item-title-row">
                                <div class="item-title">{{ Auth::user()->name }}</div>
                            </div>
                            <div class="item-subtitle">點數：<span class="margin-right-03">{{ Auth::user()->point }}</span>點</div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="card" style="margin:0px;">
        <div class="card-header text-color-blue"><span class="f7-icons diy-size-20">data_fill會員套餐</span></div>
        <div class="card-content card-content-padding">
            <div class="row">
                <div class="col-50">
                    收看方案：@if(Auth::user()->is_vip)
                        {{ Auth::user()->program->title }}
                    @else
                        無
                    @endif
                </div>
                <div class="col-50">
                    方案到期日:@if(Auth::user()->is_vip)
                        {{ Auth::user()->vip_end_time }}
                    @else
                        --
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="card" style="margin:0px;margin-top: .8em;">
        <div class="card-content me-menu text-color-blue" style="padding-top: 15px;padding-bottom: 15px;">
            <div class="row" style="margin-bottom: 2em;">
                <div class="col-33">
                    <a href="/mobile/member/userinfo" class="external">
                        <p><span class="f7-icons">gear_fill</span></p>
                        個人資料
                    </a>
                </div>
                <div class="col-33">
                    <a href="/mobile/member/point" class="external">
                    <p><span class="f7-icons">card_fill</span></p>
                    儲值點數
                    </a>
                </div>
                <div class="col-33">
                    <a href="/mobile/member/program" class="external">
                    <p><span class="f7-icons">briefcase_fill</span></p>
                    會員套餐
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-33">
                    <a href="/mobile/member/pointlog/" class="external">
                    <p><span class="f7-icons">favorites_fill</span></p>
                    消費紀錄
                    </a>
                </div>
                <div class="col-33">
                    <a href="/mobile/member/collect" class="external">
                    <p><span class="f7-icons">bookmark_fill</span></p>
                    收藏影片
                    </a>
                </div>
                <div class="col-33">
                    <a href="/mobile/member/notice/" class="external">
                    <p><span class="f7-icons">email_fill</span></p>
                    訊息
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="card" style="margin:0px; margin-top: .8em;">
        <div class="card-header text-color-blue"><span class="f7-icons diy-size-20">world_fill推廣應用</span></div>
        <div class="card-content card-content-padding">
            <p>複製下面網址進行推廣，你的推廣鏈接每被訪問一次將給您增加'1點'，24小時內多次訪問只計一次。每天點數增加的上限為40點！</p>
            <div style="width: 100%;border: 2px #007aff dashed;border-radius: 5px;padding: 9px 2px;">
                {{ env('SPREAD_URL') }}/spread?token={{ Hashids::encode(Auth::id()) }}
            </div>

        </div>
    </div>
    <div class="card" style="margin:0px; margin-top: .8em;">
        <div class="card-header text-color-blue"><span class="f7-icons diy-size-20">list_fill訊息</span></div>
        <div class="card-content card-content-padding list links-list">
            <ul class="notice-list">
                @foreach($notice as $value)
                <li data-token="{{ Hashids::encode($value->id) }}"><a href="#">{{ $value->title }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>

    <a href="/mobile/logout" class="col button button-fill button-round color-red external" style="margin-top: 1em;">登出</a>
    <div class="popup popup-about">
        <div class="block">
            <p class="title">About</p>
            <!-- Close Popup -->
            <p><a class="link popup-close" href="#">關閉窗口</a></p>
            <p class="msg-content">Lorem ipsum dolor sit amet...</p>
        </div>
    </div>
@stop
@section('script')
    <script>
        var dynamicPopup = myApp.popup.create({
            el:'.popup-about',
            on: {
                open: function (popup) {
                    console.log('Popup open');
                },
                opened: function (popup) {
                    console.log('Popup opened');
                },
            }
        });

        $$('.notice-list li').on('click',function () {
            myApp.preloader.show();
            let token = $$(this).data('token');
            myApp.request.get('/member/notify/'+token,{},function (e) {
                myApp.preloader.hide();
                $$(".title").text(e.data.title);
                $$(".msg-content").html(e.data.content);
                dynamicPopup.open();
            },function (xhr) {
                myApp.preloader.hide();
                myApp.dialog.alert(errorJsonToText( JSON.parse(xhr.response)));
            },'json');
        });
    </script>
@stop