@extends('home.layouts.common')
@section('content')
    <div class="container-fluid mt-3">
        <div class="row content-height">
            @if($video == null)
                <div class="col-lg-12">
                    <div class="alert alert-info" role="alert">
                        無內容
                    </div>
                </div>
            @else
            <div class="col-lg-12">
                <!-- list -->
                <div class="row mt-2">
                    @foreach($video as $key=>$val)
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
{{--                            {{ $video->links() }}--}}
                            {!! $video->appends(['keyword'=>$keyword])->render() !!}
                        </ul>
                    </nav>
                </div>
            </div>
            @endif
        </div>


    </div>
@stop