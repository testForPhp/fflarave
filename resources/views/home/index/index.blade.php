@extends('home.layouts.common')
@section('content')
<!-- top host -->
<div class="container-fluid">
    <div class="row carousel-main mt-3">
        <div class="col-lg-8">
            <!-- carousel start -->
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    @foreach($banner as $key=>$val)
                    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}" class="@if($key == 0)active @endif"></li>
                    @endforeach
                </ol>
                <div class="carousel-inner">
                    @foreach($banner as $key=>$val)
                    <div class="carousel-item @if($key == 0)active @endif">
                        <a href="/v/{{ Hashids::encode($val->id) }}">
                        <img class="d-block w-100" style="height: 380px;" src="{{ $imgServer }}{{ $val->thumbnail }}" alt="{{ $val->name }}">
                        <div class="carousel-caption d-none d-md-block">
                            <h5 class="text-dark">{{ $val->name }}</h5>
                        </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <!-- end carousel -->
        </div>
        <div class="col-lg-4 host">
            <!-- host start -->
            @if(isset(cache('system_base')->ads_1) && cache('system_base')->ads_1 != '')
            <div class="card bg-dark text-dark mb-3 border-0">
                <a href="{{ cache('system_base')->ads_1_link }}">
                <img class="card-img w-100" src="{{ cache('system_base')->ads_1 }}" height="180" alt="Card image">
                <div class="card-img-overlay">
                    <h5 class="card-title card-top"></h5>
                </div>
                </a>
            </div>
            @endif
            @if(isset(cache('system_base')->ads_2) && cache('system_base')->ads_2 != '')
            <div class="card bg-dark text-dark border-0">
                <a href="{{ cache('system_base')->ads_2_link }}">
                <img class="card-img w-100" src="{{ cache('system_base')->ads_2 }}" height="180" alt="Card image">
                <div class="card-img-overlay">
                    <h5 class="card-title card-top"></h5>
                </div>
                </a>
            </div>
            @endif
            <!-- end host -->
        </div>
    </div>
</div>
<!-- end top host -->
@foreach($sort as $key=>$val)
    @if(!$val->home()->isEmpty())
<div class="container-fluid mt-4">
    <nav aria-label="sub-nav">
        <ul class="list-group">
            <li class="list-group-item border-top-0 border-right-0 border-left-0 rounded-0">
                <span class="inline-block" style="font-size: 18px;"><span class="oi oi-video text-primary mr-2"></span>{{ $val->name }}</span>
                <a class="float-right" href="/list/{{ Hashids::encode($val->id) }}">More<span class="oi oi-chevron-right ml-2"></span></a>
            </li>
        </ul>
    </nav>
    <div class="row mt-2">
        @foreach($val->home() as $k=>$v)
        <div class="col-lg-3 mb-3">
            <div class="card">
                <a href="/v/{{ Hashids::encode($v->id) }}" class="card-img">
                    <span class="badge badge-info position-absolute video-pixel">{{ $v->pointData()[$v->pixel] }}</span>
                    <img class="card-img-top" src="{{ $imgServer }}{{ $v->thumbnail }}" alt="Card image cap">
                    <span class="badge badge-secondary position-absolute">{{ $v->time_limit }}</span>
                </a>
                <div class="card-body p-2">
                    <a href="/v/{{ Hashids::encode($v->id) }}"><h6 class="card-title mb-0 text-dark text-truncate">{{ $v->name }}</h6></a>
                </div>
                <div class="card-footer">
                    <small class="text-muted">
                          <span class="float-left">
                            <span class="oi oi-clock mr-1"></span>
                            {{ $v->updated_at->format('Y-m-d') }}
                          </span>
                        <span class="float-right">
                            <span class="oi oi-eye"></span>
                            {{ $v->view + $v->click }}
                          </span>
                    </small>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
    @endif
@endforeach

<!-- links -->
<div class="container-fluid mt-4">
    <nav aria-label="sub-nav">
        <ul class="list-group">
            <li class="list-group-item border-top-0 border-right-0 border-left-0 rounded-0">
                <span class="inline-block" style="font-size: 18px;"><span class="oi oi-link-intact text-primary mr-2"></span>友情鏈接</span>
            </li>
        </ul>
    </nav>
    <div class="row mt-2" style="font-size:12px;">
        @foreach($link as $v)
        <div class="col-lg-1"><a href="{{ $v->url }}" class="text-muted" target="_blank">{{ $v->name }}</a></div>
        @endforeach
    </div>
</div>
<!-- end links -->

@stop