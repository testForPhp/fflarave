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
                        <div class="row collect">
                            @foreach($video as $val)
                            <div class="col-lg-3 mb-3">
                                <div class="card">
                                    <span class="badge badge-danger pointer delete-collect" data-token="{{ Hashids::encode($val->id) }}" ><span class="oi oi-x"></span></span>
                                    <a href="#" class="card-img">
                                        <img class="card-img-top" src="{{ $imgServer . $val->thumbnail }}" alt="{{ $val->name }}">
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

                        <nav aria-label="Page navigation example mt-4">
                            <ul class="pagination justify-content-center">
                               {{ $video->links() }}
                            </ul>
                        </nav>

                    </div>
                </div>
                <!-- end content -->
            </div>
        </div>
    </div>
@stop

@section('script')
<script>
    $(".delete-collect").click(function () {
        let _this = $(this);
        token = _this.data('token');
        if(token == '' || token.length < 15){
            errorMsg('請選擇收藏');
            return false;
        }
        $.ajax({
           type: "delete",
           url: "/member/collect/" + token,
           data: "name=John&location=Boston",
           success: function(data){
               _this.parent().parent().remove();
             successMsg(data.message);
           },
            error:function (xhr) {
                errorHtmlMsg(jsonsMsg(xhr));
            }
        });
    });
</script>
@stop
