@extends('admin.layouts.common')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">視頻標籤</h3>
                </div>
                <button type="button" class="btn btn-block btn-info bt-add-tag">添加標籤</button>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>標籤名稱</th>
                            <th style="">操作</th>
                        </tr>
                        @foreach($tags as $val)
                            <tr>
                                <td>{{ $val->id }}</td>
                                <td>{{ $val->title }}</td>
                                <td width="200">
                                    <button type="button" class="btn btn-info btn-edit-tag" data-id="{{ $val->id }}">編輯</button>
                                    <button type="button" data-id="{{ $val->id }}" class="btn btn-danger">刪除</button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <ul class="pagination pagination-sm no-margin pull-right">
                        {{ $tags->links() }}
                    </ul>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <div class="modal modal-info fade" id="modal-info">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">標籤</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">標籤</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputtag" placeholder="標籤">
                                    <input type="hidden" id="inputId" value="0">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline pull-right btn-put-tag">Save</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@stop
@section('script')
<script>
    $(".bt-add-tag").click(function () {
        $("#modal-info").modal('show');
    });
    $(".btn-put-tag").click(function () {
        tag = $("#inputtag").val();
        id = $("#inputId").val();

        if(tag.length <= 0){
            $(".modal-message-body").html('標籤不能為空');
            $("#modal-message").removeClass('modal-info').addClass('modal-danger').modal('show');
            return false;
        }
        $.post("{{ $webPath }}/video/tag", { title: tag,id:id },function(data){
            $(".modal-message-body").html(data.message);
            $("#modal-message").modal('show');
            window.location.reload();
                 }).fail(function (xhr) {
            $(".modal-message-body").html(xhr.responseJSON.errors.title.join(''));
            $("#modal-message").removeClass('modal-info').addClass('modal-danger').modal('show');
        });
    });
    $(".btn-edit-tag").click(function () {
        id = $(this).data();
        if(id.id.length <= 0){
            $(".modal-message-body").html('請選擇標籤');
            $("#modal-message").removeClass('modal-info').addClass('modal-danger').modal('show');
            return false;
        }

        $.get( "{{ $webPath }}/video/tag/" + id.id, function(data) {
                $("#inputtag").val(data.data.title);
                $("#inputId").val(data.data.id);
                $("#modal-info").modal('show');
                    }).fail(function(xhr) {
            $(".modal-message-body").html(xhr.responseJSON.message);
            $("#modal-message").removeClass('modal-info').addClass('modal-danger').modal('show');
                    });
    });
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
           url: '{{ $webPath }}/video/tag/'+id.id,
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