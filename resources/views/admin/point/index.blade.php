@extends('admin.layouts.common')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">點數套餐</h3>
                    <a type="button" class="btn btn-info" href="{{ $webPath }}/point/create"><i class="fa  fa-plus"></i>添加方案</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>名稱</th>
                            <th>點數</th>
                            <th>價格</th>
                            <th>簡介</th>
                            <th>激活嗎</th>
                            <th>排序</th>
                            <th>操作</th>
                        </tr>
                        @foreach($point as $val)
                            <tr>
                                <td>{{ $val->id }}</td>
                                <td>{{ $val->title }}</td>
                                <td>{{ $val->point }}</td>
                                <td>{{ $val->money }}</td>
                                <td>{{ $val->summary }}</td>
                                <td><a href="{{ $webPath }}/pay-code/0/{{ $val->id }}">查看激活嗎</a></td>
                                <td>{{ $val->sort }}</td>
                                <td>
                                    <a href="{{ $webPath }}/point/{{ $val->id }}/edit" class="btn btn-info">編輯</a>
                                    <button type="button" class="btn btn-success" data-id="{{ $val->id }}">生成激活嗎</button>
                                    <button type="button" data-id="{{ $val->id }}" class="btn btn-danger">刪除</button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
@stop
@section('script')
    <script>
        $(".btn-danger").click(function () {
            id = $(this).data();
            _this = $(this);
            if(id.id.length <= 0){
                $(".modal-message-body").html('標籤不能為空');
                $("#modal-message").removeClass('modal-info').addClass('modal-danger').modal('show');
                return false;
            }
            $.ajax({
                type: "delete",
                url: '{{ $webPath }}/point/'+id.id,
                data: "",
                success: function(msg){
                    $(".modal-message-body").html(msg.message);
                    $("#modal-message").modal('show');
                    _this.parent().parent().remove();
                },
                error:function (xhr) {
                    $(".modal-message-body").html(xhr.responseJSON.message);
                    $("#modal-message").removeClass('modal-info').addClass('modal-danger').modal('show');
                }
            });
        });
        $(".btn-success").click(function () {
            let id = $(this).data('id');
            if(id == ''){
                $(".modal-message-body").html('標籤不能為空');
                $("#modal-message").removeClass('modal-info').addClass('modal-danger').modal('show');
                return false;
            }
            $.post("{{ $webPath }}/pay-code", { id:id },function(data){
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
    </script>
@stop