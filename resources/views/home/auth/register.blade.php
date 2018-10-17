@include('home.layouts.header')
<body class="reg">
@include('home.layouts.nav')

<div class="container-fluid">
    <div class="row pt-5">
        <div class="card m-auto pt-4 pb-4 pl-4 pr-4">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="post" action="{{ route('register') }}" aria-label="{{ __('Register') }}" onsubmit="return check(this)">
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" id="exampleInputUsername" aria-describedby="UserHelp" placeholder="請輸入用戶暱稱" value="{{ old('name') }}">
                        <small id="UserHelp" class="form-text text-muted">We'll never share your user info with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="請輸入郵箱" value="{{ old('email') }}">
                        <small id="emailHelp" class="form-text text-danger">請填寫可收件的郵箱，用於找回密碼使用,註冊後不能修改！</small>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="請輸入密碼">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="確認密碼">
                    </div>
                    <div class="form-check mb-2 text-danger">
                        <input class="form-check-input" type="checkbox" name="is_adult" value="1" id="defaultCheck1">
                        {{ csrf_field() }}
                        <label class="form-check-label" for="defaultCheck1">
                            我已年滿18歲
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">註冊會員</button>
                </form>
            </div>
            <div class="card-footer bg-white">
                <span class="text-muted">已經註冊賬號，<a href="/login">請前往登陸</a></span>
            </div>
        </div>
    </div>
</div>
@include('home.layouts.js')
<script>
        function check(form) {
            // errorMsg = checkForm(form)
            // if(errorMsg != ''){
            //     errorHtmlMsg(errorMsg);
            //     return false;
            // }
            return true;
        }

        function checkForm(data)
        {
            let errorMsg = '';

            if(data.name.value.length < 5){
                errorMsg += "<p>暱稱不能為空或少於5位！</p>";
            }
            if(checkEmail(data.email.value) == false){
                errorMsg += "<p>請填寫正確的E-mail！</p>";
            }
            if(data.password.value.length < 6){
                errorMsg += "<p>密碼不能為空或少於6位！</p>";
            }
            if(data.password.value != data.password_confirmation.value){
                errorMsg += "<p>兩次密碼不一致！</p>";
            }
            if($("input[type='checkbox']").is(':checked') == false){
                errorMsg += "<p'>請確認您是否已滿18歲，如為滿18歲，請離開本站！感謝合作！</p>";
            }
            return errorMsg;
        }
</script>
{!! cache('system_base')->count !!}
</body>
</html>