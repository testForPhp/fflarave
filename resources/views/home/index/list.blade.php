@extends('home.layouts.common')
@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">首頁</a></li>
                        <li class="breadcrumb-item">视频</li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $sort->name }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-12">
                <!-- list -->
                <div class="row mt-2">
                    @foreach($sort->idByVideoPaginate() as $key=>$val)
                    <div class="col-lg-3 mb-3">
                        <div class="card">
                            <a href="/v/{{ Hashids::encode($val->id) }}" class="card-img">
                                <span class="badge badge-info position-absolute video-pixel">{{ $val->pointData()[$val->pixel] }}</span>
                                <img class="card-img-top" src="{{ $imgServer }}{{ $val->thumbnail }}" alt="{{ $val->name }}">
                                <span class="badge badge-secondary position-absolute">{{ $val->time_limit }}</span>
                            </a>
                            <div class="card-body p-2">
                                <a href="/v/{{ Hashids::encode($val->id) }}"><h6 class="card-title mb-0 text-dark text-truncate">{{ $val->name }}</h6></a>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">
                          <span class="float-left">
                            <span class="oi oi-clock mr-1"></span>
                            {{ $val->updated_at->format('Y-m-d') }}
                          </span>
                                    <span class="float-right">
                            <span class="oi oi-eye"></span>
                            {{ $val->view + $val->click }}
                          </span>
                                </small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- end list -->
                <div class="col-lg-12 mt-4">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            {{ $sort->idByVideoPaginate()->links() }}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>


    </div>
@stop