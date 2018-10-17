@extends('home.layouts.common')
@section('content')
    <div class="container-fluid mt-4">
        <div class="row content-height">
            <div class="col-lg-2">
                <!-- menu -->
                @include('home.layouts.side')
                <!-- end menu -->
            </div>
            <div class="col-lg-1"></div>
            <div class="col-lg-9">
                <!-- content -->
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered user-info">
                            <thead>
                            <tr>
                                <th scope="col" colspan="2" class="bg-light">會員資料</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row" >暱稱：</th>
                                <td><span class="username">{{ Auth::user()->name }}</span><span class="oi oi-pencil ml-4 edit-username pointer" ></span></td>
                            </tr>
                            <tr>
                                <th scope="row">郵箱：</th>
                                <td>{{ Auth::user()->email }}</td>
                            </tr>
                            <tr>
                                <th scope="row">修改密碼：</th>
                                <td>******<span class="oi oi-pencil ml-4 edit-password pointer"></span></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end content -->
            </div>
        </div>
    </div>
    <div class="modal fade" id="usernameModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">暱稱修改</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body notice-content">
                    <form>
                        <div class="form-group">
                            <input type="text" class="form-control" id="edit-username" aria-describedby="emailHelp" placeholder="請輸入暱稱">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="edit-username-password" placeholder="請輸入密碼確認修改">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary put-username">提交修改</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">密碼修改</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body notice-content">
                    <form>
                        <div class="form-group">
                            <input type="password" class="form-control" id="inputPassword" aria-describedby="emailHelp" placeholder="請輸入新密碼">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="inputPasswordConfirmation" placeholder="請再次確認新密碼">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="inputOldPassword" placeholder="請輸入旧密碼進行驗證">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary put-password">提交修改</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
<script>
    $(".edit-username").click(function () {
        $("#usernameModal").modal('show');
    });
    $(".edit-password").click(function () {
        $("#passwordModal").modal('show');
    });
    $(".put-password").click(function () {
        let password = $("#inputPassword").val();
        let password_confirmation = $("#inputPasswordConfirmation").val();
        let old_password = $("#inputOldPassword").val();

        if(password == '' || password.length < 6 || old_password == '' || old_password.length < 6){
            errorMsg('密碼不能為空或小於6位');
            return false;
        }
        if(password != password_confirmation){
            errorMsg('兩次密碼不一致');
            return false;
        }
        $.ajax({
           type: "PUT",
           url: "/member/info/password",
           data: {password:password,password_confirmation:password_confirmation,oldpassword:old_password},
           success: function(e){
               $("#passwordModal").modal('hide');
               successMsg(e.message);
           },
            error:function (xhr) {
                errorHtmlMsg(jsonsMsg(xhr));
            }
        });
    });
    $(".put-username").click(function () {
        let username = $("#edit-username").val();
        let password = $("#edit-username-password").val();

        if(username == '' || username.length < 5){
            errorMsg('用戶名不能為空或少於6位！');
            return false;
        }
        if(password == '' || password.length < 6){
            errorMsg('密碼不能為空或小於6位');
            return false;
        }

        $.ajax({
           type: "put",
           url: "/member/info/username",
           data: {username:username,password:password},
           success: function(e){
               $(".username").text(username);
               $("#usernameModal").modal('hide');
               successMsg(e.message);
           },
            error:function (xhr) {
                errorHtmlMsg(jsonsMsg(xhr));
            }
        });

    });
</script>
@stop