@include('home.layouts.header')
<body class="reg">
@include('home.layouts.nav')

<div class="container-fluid">
    <div class="row pt-5">
        <div class="card m-auto pt-4 pb-4 pl-4 pr-4">
            <div class="card-body">
                <form method="post" action="{{ route('login') }}">
                    <div class="form-group">
                        <input type="text" class="form-control" name="email" id="exampleInputEmail" aria-describedby="UserHelp" placeholder="請輸入E-mail" value="{{ old('email') }}" required autofocus>
                        <small id="UserHelp" class="form-text text-muted">We'll never share your user info with anyone else.</small>
                        @if ($errors->has('email'))
                            <span class="help-block text-lowercase text-danger" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="請輸入密碼" required>
                        {{ csrf_field() }}
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif

                    </div>
                    <button type="submit" class="btn btn-primary">確認登入</button>
                </form>
            </div>
            <div class="card-footer bg-white text-muted">
                <span>沒有賬號，<a href="/register">請前往註冊</a></span>
                <span class="float-right"><a href="{{ route('password.request') }}">忘記密碼？</a></span>
            </div>
        </div>
    </div>
</div>

@include('home.layouts.js')

{!! cache('system_base')->count !!}
</body>
</html>