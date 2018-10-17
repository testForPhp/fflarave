<!-- nav start -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="@if(isset(cache('system_base')->url)){{ cache('system_base')->url }}@else / @endif">@if(isset(cache('system_base')->logo) && cache('system_base')->logo != '')<img
                src="{{ cache('system_base')->logo }}" width="120" height="50" alt="">@else{{ cache('system_base')->website }}@endif</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse ml-2" id="navbarSupportedContent">
        <ul class="navbar-nav mr-5">
            <li class="nav-item active mr-2">
                <a class="nav-link" href="/">首頁</a>
            </li>
            @if(isset(cache('menu')[0]))
                @foreach(cache('menu') as $value)
                    @if(isset($value['child']))
                        <li class="nav-item dropdown mr-2">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ $value['name'] }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @foreach($value['child'] as $item)
                                <a class="dropdown-item" href="/list/{{ $item['id'] }}">{{ $item['name'] }}</a>
                                @endforeach
                            </div>
                        </li>
                    @else
                        <li class="nav-item mr-2">
                            <a class="nav-link" href="/list/{{ $value['id'] }}">{{ $value['name'] }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        </ul>
        <form class="form-inline my-2 my-lg-0" method="get" action="/search">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" name="keyword" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">檢索</button>
        </form>
        <ul class="navbar-nav ml-auto">
            @guest
            <li class="nav-item active">
                <a class="nav-link" href="/login">登陸</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/register">註冊</a>
            </li>
                @else
                <li class="nav-item active">
                    <a class="nav-link" href="/member/">會員中心</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/logout">登出</a>
                </li>
                @endif
        </ul>
    </div>
</nav>
<!-- end nav -->