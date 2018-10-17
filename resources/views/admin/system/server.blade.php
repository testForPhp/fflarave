@extends('admin.layouts.common')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Bordered Table</h3>
                </div>
                <a type="button" class="btn btn-block btn-info" href="{{ $webPath }}/system/server/create">添加伺服器</a>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>伺服器名稱</th>
                            <th>地址</th>
                            <th>是否激活</th>
                            <th style="">操作</th>
                        </tr>
                        @foreach($servers as $val)
                            <tr>
                                <td>{{ $val->id }}</td>
                                <td>{{ $val->name }}</td>
                                <td>
                                    {{ $val->site }}
                                </td>
                                <td>
                                    {{ empty($val->is_active) ? '否' : '是' }}
                                </td>
                                <td width="200">
                                    <a type="button" class="btn btn-info" href="{{ $webPath }}/system/server/{{ $val->id }}/edit/">編輯</a>
                                    <button type="button" data-id="{{ $val->id }}" class="btn btn-danger">刪除</button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <ul class="pagination pagination-sm no-margin pull-right">
                        {{ $servers->links() }}
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
           url: "{{ $webPath }}/system/server/"+id.id,
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