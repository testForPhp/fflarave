@extends('mobile.layouts.app')
@section('content')
    <div class="login-screen-title">@if(isset(cache('system_base')->website)){{ cache('system_base')->website }} @else JapanXav @endif</div>
    <form>
        <div class="list">
            <ul>
                <li class="item-content item-input">
                    <div class="item-inner">
                        <div class="item-title item-label">郵箱</div>
                        <div class="item-input-wrap">
                            <input type="email" name="email" id="email" placeholder="請輸入郵箱">
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="list">
            <ul>
                <li style="padding: 0px 10px;"><button class="col button button-fill letter-spacing-4" type="button">提交</button></li>
            </ul>
            <div class="block-footer">
                <p><a class="link external" href="/mobile/login">返回登陸</a></p>
            </div>
        </div>
    </form>
@stop
@section('script')
<script>
    $$(".page-content").addClass('login-screen-content');
    $$(".button-fill").on('click',function (e) {
        myApp.preloader.show();

        let email = $$("#email").val();
        if(checkEmail(email) == false){
            myApp.preloader.hide();
            myApp.dialog.alert('請輸入合法的郵箱！');
            return false;
        }
        myApp.request.post('/mobile/forgot',{email:email},function (e) {
            myApp.preloader.hide();
            myApp.dialog.alert(e.message);
        },function (xhr) {
            myApp.preloader.hide();
            myApp.dialog.alert(errorJsonToText( JSON.parse(xhr.response)));
        },'json');
    });
</script>
@stop