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
                                <td>{{ Auth::user()->name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">郵箱：</th>
                                <td>{{ Auth::user()->email }}</td>
                            </tr>
                            <tr>
                                <th scope="row">現有點數：</th>
                                <td style="letter-spacing: 3px;">{{ Auth::user()->point }}點</td>
                            </tr>
                            <tr>
                                <th scope="row">收看方案：</th>
                                <td>@if(Auth::user()->is_vip)
                                    {{ Auth::user()->program->title }}
                                        @else
                                        無
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">方案到期日：</th>
                                <td>
                                    @if(Auth::user()->is_vip)
                                        {{ Auth::user()->vip_end_time }}
                                    @else
                                    --
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">最後登錄：</th>
                                <td>{{ Auth::user()->updated_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-12 mb-3">
                        <div class="card rounded-0 message" style="">
                            <div class="card-header font-weight-bold">
                                推廣應用
                            </div>
                            <div class="card-body">
                                <p class="text-justify">複製下面網址進行推廣，你的推廣鏈接每被訪問一次將給您增加'1點'，24小時內多次訪問只計一次。每天點數增加的上限為40點！</p>
                                <div class="alert alert-info" role="alert">
                                    {{ env('SPREAD_URL') }}/spread?token={{ Hashids::encode(Auth::id()) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card rounded-0 message" style="">
                            <div class="card-header font-weight-bold">
                                訊息
                            </div>
                            <ul class="list-group list-group-flush">
                                @foreach($notify as $value)
                                <li class="list-group-item message-li" data-token="{{ Hashids::encode($value->id) }}">
                                    {{ $value->title }} <span class="float-right">{{ $value->updated_at->format('Y-m-d') }}</span>
                                </li>
                                    @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- end content -->
            </div>
        </div>
    </div>

    <!-- modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal -->
@stop

@section('script')
<script>
    $(".message-li").click(function () {
        let token = $(this).data('token');
        $.get( "/member/notify/" + token, function(data) {
                        $(".modal-title").text(data.data.title);
                        $(".modal-body").html(data.data.content)
                        $("#exampleModal").modal('show');
                    })
                        .fail(function(xhr) {
                            errorMsg(xhr.responseJSON.message)
                        });
    });
</script>
@stop