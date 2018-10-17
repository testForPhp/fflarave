@extends('mobile.layouts.app')
@section('content')
    <div class="list">
        <ul>
            @foreach($program as $value)
            <li>
                <a href="#" class="item-link item-content" data-token="{{  Hashids::encode($value->id) }}">
                    <div class="item-media">
                        <i class="f7-icons text-color-pink">today_fill</i>
                    </div>
                    <div class="item-inner">
                        <div class="item-title">
                            <div class="item-header">@if($value->sales == 0){{ $value->total }}@else{{ $value->sales }} @endif 點{{ $value->title }}</div>
                            {{ $value->summary }}
                        </div>
                        <div class="item-after">購買</div>
                    </div>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
@stop
@section('script')
<script>
    $$(".page-content").addClass('login-screen-content');
    $$(".item-content").on('click',function () {
        let token = $$(this).data('token');

        myApp.dialog.confirm('確認購買?', function () {

            myApp.preloader.show();

            if(token == ''){
                myApp.preloader.hide();
                myApp.dialog.alert('請選擇套餐方案！');
                return false;
            }
            myApp.request.post('/member/program',{token:token},function (e) {
                myApp.preloader.hide();
                notifications('方案購買成功',e.message).open();
            },function (xhr) {
                myApp.preloader.hide();
                myApp.dialog.alert(errorJsonToText( JSON.parse(xhr.response)));
            },'json');

        });

    });
</script>
@stop