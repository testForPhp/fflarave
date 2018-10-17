@extends('mobile.layouts.app')
@section('content')
    <div class="login-screen-title">@if(isset(cache('system_base')->website)){{ cache('system_base')->website }} @else JapanXav @endif</div>
    <form id="myForm">
        <div class="list">
            <ul>
                <li class="item-content item-input">
                    <div class="item-inner">
                        <div class="item-title item-label">郵箱</div>
                        <div class="item-input-wrap">
                            <input type="email" name="email" placeholder="請輸入郵箱">
                        </div>
                    </div>
                </li>
                <li class="item-content item-input">
                    <div class="item-inner">
                        <div class="item-title item-label">密碼</div>
                        <div class="item-input-wrap">
                            <input type="password" name="password" placeholder="請輸入密碼">
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
                <p><a class="link external" href="/mobile/register">還沒有帳號？前往註冊</a></p>
                <p><a class="link external" href="/mobile/forgot">忘記密碼？前往找回</a></p>
            </div>
        </div>
    </form>
@stop
@section('script')
<script>
    $$(".page-content").addClass('login-screen-content');

    $$(".button-fill").on('click',function (e) {
        myApp.preloader.show();

        let formData  = myApp.form.convertToData('#myForm');
        let msgError = '';
        let isOk = true;

        if(checkEmail(formData.email) == false){
            msgError += '<p>請輸入合法的郵箱！</p>';
            isOk = false;
        }

        if(formData.password == '' || formData.password.length < 6){
            msgError += '<p>密碼不能為空且不能少於6位！</p>';
            isOk = false;
        }

        if(isOk == false){
            myApp.preloader.hide();
            myApp.dialog.alert(msgError);
            return false;
        }

        myApp.request.post('/mobile/login',formData,function (e) {
            if(e.code == 0){
                window.location.href = e.data.url;
            }
        },function (xhr) {
            myApp.preloader.hide();
            myApp.dialog.alert(errorJsonToText( JSON.parse(xhr.response)));
        },'json');

    });
</script>
@stop