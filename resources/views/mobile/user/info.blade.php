@extends('mobile.layouts.app')
@section('content')
    <div class="list" style="margin-top: .2em">
        <ul>
            <li>
                <a href="#" class="item-link item-content popup-open" data-popup=".popup-about">
                    <div class="item-inner username">
                        <div class="item-title">用戶名</div>
                        <div class="item-after">{{ Auth::user()->name }}</div>
                    </div>
                </a>
            </li>
            <li>
                <a href="#" class="item-link item-content">
                    <div class="item-inner" style="background-image: url();padding-right:15px;">
                        <div class="item-title">郵箱</div>
                        <div class="item-after">{{ Auth::user()->email }}</div>
                    </div>
                </a>
            </li>
            <li>
                <a href="#" class="item-link item-content popup-open" data-popup=".popup-password">
                    <div class="item-inner">
                        <div class="item-title">密碼</div>
                        <div class="item-after">******</div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <div class="popup popup-about login-screen">
        <div class="view">
            <div class="page">
                <div class="page-content login-screen-content">
                    <div class="login-screen-title">修改用戶名</div>
                    <form id="upUsernameForm">
                        <div class="list">
                            <ul>
                                <li class="item-content item-input">
                                    <div class="item-inner">
                                        <div class="item-title item-label">用戶名</div>
                                        <div class="item-input-wrap">
                                            <input type="text" name="username" placeholder="請輸入新用戶名">
                                        </div>
                                    </div>
                                </li>
                                <li class="item-content item-input">
                                    <div class="item-inner">
                                        <div class="item-title item-label">密碼</div>
                                        <div class="item-input-wrap">
                                            <input type="password" name="password" placeholder="請輸入密碼確認">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="list">
                            <ul>
                                <li style="padding: 0px 15px;">
                                    <button class="col button button-fill update-username" type="button">提交</button>
                                </li>
                            </ul>
                            <div class="block-footer">
                                <button class="col color-red button button-fill login-screen-close" type="button">關閉返回</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="popup popup-password login-screen">
        <div class="view">
            <div class="page">
                <div class="page-content login-screen-content">
                    <div class="login-screen-title">修改密碼</div>
                    <form id="updatePassword">
                        <div class="list">
                            <ul>
                                <li class="item-content item-input">
                                    <div class="item-inner">
                                        <div class="item-title item-label">新密碼</div>
                                        <div class="item-input-wrap">
                                            <input type="password" name="password" placeholder="請輸入新密碼">
                                        </div>
                                    </div>
                                </li>
                                <li class="item-content item-input">
                                    <div class="item-inner">
                                        <div class="item-title item-label">確認密碼</div>
                                        <div class="item-input-wrap">
                                            <input type="password" name="password_confirmation" placeholder="請輸入新密碼">
                                        </div>
                                    </div>
                                </li>
                                <li class="item-content item-input">
                                    <div class="item-inner">
                                        <div class="item-title item-label">原始密碼</div>
                                        <div class="item-input-wrap">
                                            <input type="password" name="oldpassword" placeholder="請輸入原始密碼確認">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="list">
                            <ul>
                                <li style="padding: 0px 15px;">
                                    <button class="col button button-fill put-update-password" type="button">提交</button>
                                </li>
                            </ul>
                            <div class="block-footer">
                                <button class="col color-red button button-fill login-screen-close" type="button">關閉返回</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
<script>
    $$('.popup-about').on('popup:open', function (e, popup) {
        console.log('About popup open');
    });
    $$('.popup-about').on('popup:opened', function (e, popup) {
        console.log('About popup opened');
    });
    $$('.popup-password').on('popup:open', function (e, popup) {
        console.log('About popup open');
    });
    $$('.popup-password').on('popup:opened', function (e, popup) {
        console.log('About popup opened');
    });

    $$(".put-update-password").on('click',function () {
        myApp.preloader.show();
        let formData = myApp.form.convertToData('#updatePassword');
        let msgError = '';
        let isOk = true;

        if(formData.password =='' || formData.password.length < 6){
            msgError += '<p>密碼不能為空且不能少於6位</p>';
            isOk = false;
        }

        if(formData.password != formData.password_confirmation){
            msgError += '<p>兩次密碼不一致</p>'
            isOk = false;
        }

        if(formData.oldpassword == '' || formData.oldpassword.length < 6){
            msgError += '<p>原始密碼不能為空且不能少於6位</p>';
            isOk = false;
        }
        if(isOk == false){
            myApp.preloader.hide();
            myApp.dialog.alert(msgError);
            return false;
        }
        myApp.request({
            method:'PUT',
            dataType:'json',
            url:'/member/info/password',
            data:formData,
            success:function (data) {
                myApp.dialog.alert(data.message);
            },
            error:function (xhr) {
                myApp.dialog.alert(errorJsonToText(JSON.parse(xhr.response)));
            },
            complete:function (xhr) {
                myApp.preloader.hide();
            }
        });
    });

    $$(".update-username").on('click',function (e) {
        myApp.preloader.show();
        let formData = myApp.form.convertToData('#upUsernameForm');
        let msgError = '';
        let isOk = true;

        if(formData.username == '' || formData.username.length < 5){
            msgError += '<p>用戶名不能為空且不能少於5位</p>';
            isOk = false;
        }
        if(formData.password == '' || formData.password.length < 6){
            msgError += '<p>密碼不能為空且不能少於6位</p>';
            isOk = false;
        }

        if(isOk == false){
            myApp.preloader.hide();
            myApp.dialog.alert(msgError);
            return false;
        }

        myApp.request({
            method:'PUT',
            dataType:'json',
            url:'/member/info/username',
            data:formData,
            success:function (data) {
                $$(".username .item-after").text(formData.username);
                myApp.dialog.alert(data.message);
            },
            error:function (xhr) {
                myApp.dialog.alert(errorJsonToText(JSON.parse(xhr.response)));
            },
            complete:function (xhr) {
                myApp.preloader.hide();
            }
        });

    });

</script>
@stop