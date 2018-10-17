@extends('admin.layouts.common')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Bordered Table</h3>
                    <button class="btn btn-info open-show" >添加支付嗎</button>
                </div>
                <div class="row">
                    <form action="{{ $webPath }}/pay-code/search" method="get">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" name="code" placeholder="请输入支付码">
                    </div>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" name="money" placeholder="请输入金额">
                        <input type="hidden" name="status" value="{{ $status }}">
                        {{ csrf_field() }}
                    </div>
                    <div class="col-lg-4">
                        <button type="submit" class="btn btn-info">搜索</button>
                    </div>
                    </form>
                </div>

                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>支付嗎</th>
                            <th>狀態</th>
                            <th>時間</th>
                            <th style="">操作</th>
                        </tr>
                        @foreach($codes as $val)
                            <tr>
                                <td>{{ $val->id }}</td>
                                <td>{{ $val->code }}</td>
                                <td>@if($val->status == 1)已使用 @else 未使用 @endif</td>
                                <td>
                                    {{ $val->created_at->format('Y-m-d') }}
                                </td>
                                <td width="200">
                                    <button type="button" data-id="{{ $val->id }}" class="btn btn-danger">刪除</button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <ul class="pagination pagination-sm no-margin pull-right">
                        {{ $codes->links() }}
                    </ul>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <div class="modal modal-info fade" id="modal-info-code">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">支付嗎</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">價格</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputCode" placeholder="價格">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline pull-right btn-put-code">Save</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
@section('script')
    <script>
        $(function () {

            $(".open-show").click(function () {
                $("#modal-info-code").modal('show');
            });

            $(".btn-put-code").click(function () {
                let money = parseInt($("#inputCode").val());

                if(money < 0){
                    $(".modal-message-body").html('金额不能小于0');
                    $("#modal-message").modal('show');
                    return false;
                }

                $.post("{{ $webPath }}/pay-code", { money:money },function(data){
                            let _html = '';
                            $.each(data.data,function (index,val) {
                                _html += '<p>' + val + '</p>';
                            });
                        $(".modal-message-body").html(_html);
                        $("#modal-message").modal('show');
                        $("#modal-info-code").modal('hide');
                         })
                    .fail(function (xhr) {
                        $(".modal-message-body").html(xhr.responseJSON.message);
                        $("#modal-message").removeClass('modal-info').addClass('modal-danger').modal('show');
                    });


            });

            $(".btn-danger").click(function () {
                id = $(this).data();
                _this = $(this);
                $.ajax({
                   type: "delete",
                   url: "{{ $webPath }}/pay-code/" + id.id,
                   data: "name=John&location=Boston",
                   success: function(data){
                       $(".modal-message-body").html(data.message);
                       $("#modal-message").modal('show');
                       _this.parent().parent().remove();
                   },
                    error:function (xhr) {
                        $(".modal-message-body").html(xhr.responseJSON.message);
                        $("#modal-message").removeClass('modal-info').addClass('modal-danger').modal('show');
                    }
                });

            });
        });

    </script>
@endsection