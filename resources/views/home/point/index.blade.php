@extends('home.layouts.common')
@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
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
                        <div class="card">
                            <div class="card-header">
                                說明
                            </div>
                            <div class="card-body">
                                <p class="card-text">1、在"儲值點數"選擇需要儲值的點數，然後點擊"前往支付"，之後會打開一個新的頁面，請在該頁面進行支付，支付完成後會得到一個激活嗎！</p>
                                <p class="card-text">2、將第一步得到的激活嗎複製到"點數兌換"裡面點擊"提交激活"，就完成儲值！</p>
                                <p class="card-text">3、接下來您可以直接前往購買視頻觀看，或者購買觀看方案！</p>

                            </div>
                        </div>
                        <div class="card rounded-0 mt-3" >
                            <div class="card-header font-weight-bold">
                                儲值點數
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col">儲值點數</th>
                                            <th scope="col">消費金額</th>
                                            <th scope="col">優惠內容</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($point as $key=>$val)
                                        <tr>
                                            <th scope="row">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="customRadioInline{{$key}}" name="pointurl" value="{{ $val->link }}" class="custom-control-input" @if($key == 0) checked @endif>
                                                    <label class="custom-control-label" for="customRadioInline{{ $key }}">{{ $val->title }}</label>
                                                </div>
                                            </th>
                                            <td>{{ $val->money }}</td>
                                            <td>{{ $val->summary or '--' }}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <a class="btn btn-primary btn-lg pay-put-point" href="{{ env('PLAY_PREFIX_URL') . $point[0]->link }}" target="_blank">前往支付</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card rounded-0 mt-3" >
                            <div class="card-header font-weight-bold">
                                點數兌換
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="input-group mb-3 input-group-lg">
                                        <input type="text" class="form-control" placeholder="請輸入您的激活碼" aria-label="Recipient's username" aria-describedby="basic-addon2" id="input-code">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary put-code" type="button">提交激活</button>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="card rounded-0 mt-3" >
                            <div class="card-header font-weight-bold">
                                收看方案
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="row">
                                        @foreach($program as $val)
                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <div class="col-lg-9 pt-4 pb-3 text-secondary border border-primary">
                                                    <h5>{{ $val->title }}</h5>
                                                    <p class="text-primary">{{ $val->summary }}</p>
                                                </div>
                                                <button class="col-lg-2 bg-primary pt-4 pb-3 text-white text-center border border-primary pointer put-program-buy" data-token="{{ Hashids::encode($val->id) }}">
                                                    BUY
                                                </button>
                                                <div class="col-lg-1"></div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- end content -->
            </div>
        </div>
    </div>
@stop
@section('script')
<script>
    let jump = "{{ env('PLAY_PREFIX_URL') }}";

    $("input[name='pointurl']").change(function () {
        let url = $(this).val();

        if(url == ''){
            errorMsg('請選擇！');
            return false;
        }
        $(".pay-put-point").attr('href',jump + url);
    });
    $(".put-code").click(function () {
        let code = $("#input-code").val();
        if(code == ''){
            errorMsg('激活嗎不能為空！');
            return false;
        }
        if(code.length < 6){
            errorMsg('激活嗎不能少於6位');
            return false;
        }
        $.post("/member/point", { code: code},function(data){
                  successMsg(data.message);
                 })
            .fail(function (xhr) {
                errorMsg(jsonsMsg(xhr));
            });
    });
    $(".put-program-buy").click(function () {
        let token = $(this).data('token');
        if(token == '' || token.length < 15){
            errorMsg('請選擇觀看方案');
            return false;
        }
        $.post("/member/program", { token: token },function(data){
                  successMsg(data.message);
                 })
            .fail(function (xhr) {
                errorMsg(jsonsMsg(xhr));
            });
    });
</script>
@stop