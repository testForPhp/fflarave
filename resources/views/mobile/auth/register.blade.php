@extends('mobile.layouts.app')
@section('content')
    <div class="login-screen-title">@if(isset(cache('system_base')->website)){{ cache('system_base')->website }} @else JapanXav @endif</div>
    <form id="myform">
        <div class="list">
            <ul>
                <li class="item-content item-input">
                    <div class="item-inner">
                        <div class="item-title item-label">用戶名</div>
                        <div class="item-input-wrap">
                            <input type="text" name="name" id="username" placeholder="請輸入用戶名">
                        </div>
                    </div>
                </li>
                <li class="item-content item-input">
                    <div class="item-inner">
                        <div class="item-title item-label">郵箱</div>
                        <div class="item-input-wrap">
                            <input type="email" name="email" id="email" placeholder="請輸入郵箱">
                        </div>
                    </div>
                </li>
                <li class="item-content item-input">
                    <div class="item-inner">
                        <div class="item-title item-label">密碼</div>
                        <div class="item-input-wrap">
                            <input type="password" name="password" id="password" placeholder="請輸入密碼">
                        </div>
                    </div>
                </li>
                <li class="item-content item-input">
                    <div class="item-inner">
                        <div class="item-title item-label">確認密碼</div>
                        <div class="item-input-wrap">
                            <input type="password" name="password_confirmation" id="confirmPwd" placeholder="請確認密碼">
                        </div>
                    </div>
                </li>
                <li class="item-content item-input">
                    <div class="item-inner">
                        <label class="item-checkbox item-content">
                            <input type="checkbox" name="age" value="1"/>
                            <i class="icon icon-checkbox"></i>
                            <div class="item-inner">
                                <div class="item-title">已滿十八歲</div>
                            </div>
                        </label>
                    </div>
                </li>
            </ul>
        </div>
        <div class="list">
            <ul>
                <li style="padding: 0px 10px;"><button class="col button button-fill letter-spacing-4" type="button">提交</button></li>
            </ul>
            <div class="block-footer">
                <p>請填寫可收件的郵箱，用於找回密碼使用,註冊後不能修改！</p>
                <p><a class="link external" href="/mobile/login">已有帳號？前往登陸</a></p>
            </div>
        </div>
    </form>
@stop
@section('script')
<script>
    $$(".page-content").addClass('login-screen-content');
    $$(".button-fill").on('click',function (e) {
        let formData  = myApp.form.convertToData('#myform');
        myApp.preloader.show();

        let alertMeg = '';
        let isOk = true;
        if(formData.name == '' || formData.name.length < 5){
            alertMeg += "<p>用戶名不能為空且不能少於5位！</p>";
            isOk =  false;
        }

        if(checkEmail(formData.email) == false){
            alertMeg += '<p>請輸入合法的郵箱，註冊後郵箱不能修改！</p>';
            isOk =  false;
        }
        if(formData.password == '' || formData.password.length < 6){
            alertMeg += '<p>密碼不能為空且密碼不能少於6位！</p>';
            isOk =  false;
        }
        if(formData.password != formData.password_confirmation){
            alertMeg += '<p>兩次密碼不一致！</p>';
            isOk =  false;
        }

        if(formData.age == ''){
            alertMeg += '<p>請確認您已滿十八歲！</p>';
            isOk = false;
        }

        if(isOk == false){
            myApp.preloader.hide();
            myApp.dialog.alert(alertMeg);
            return false;
        }

        myApp.request.post('/mobile/register',formData,function (e) {
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