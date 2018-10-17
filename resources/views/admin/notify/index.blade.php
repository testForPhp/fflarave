@extends('admin.layouts.common')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Bordered Table</h3>
                </div>
                <a type="button" class="btn btn-block btn-info" href="{{ $webPath }}/system/notify/create">添加通知</a>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>標題</th>
                            <th>添加時間</th>
                            <th>修改時間</th>
                            <th style="">操作</th>
                        </tr>
                        @foreach($notifys as $val)
                            <tr>
                                <td>{{ $val->id }}</td>
                                <td>{{ $val->title }}</td>
                                <td>{{ $val->created_at->format('Y-m-d') }}</td>
                                <td>{{ $val->updated_at->format('Y-m-d') }}</td>
                                <td width="200">
                                    <a type="button" class="btn btn-info" href="{{ $webPath }}/system/notify/{{ $val->id }}/edit/">編輯</a>
                                    <button type="button" data-id="{{ $val->id }}" class="btn btn-danger">刪除</button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <ul class="pagination pagination-sm no-margin pull-right">
                        {{ $notifys->links() }}
                    </ul>
                </div>
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
            $.ajax({
                type: "delete",
                url: "{{ $webPath }}/system/notify/"+id.id,
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
    </script>
@stop