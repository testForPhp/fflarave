@extends('admin.layouts.common')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">友情鏈接</h3>
                </div>
                <button type="button" class="btn btn-block btn-info bt-add-tag">添加連結</button>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>名稱</th>
                            <th>連結</th>
                            <th>排序</th>
                            <th>添加時間</th>
                            <th>修改時間</th>
                            <th style="">操作</th>
                        </tr>
                        @foreach($links as $val)
                            <tr>
                                <td>{{ $val->id }}</td>
                                <td>{{ $val->name }}</td>
                                <td>{{ $val->url }}</td>
                                <td>{{ $val->sort }}</td>
                                <td>{{ $val->created_at }}</td>
                                <td>{{ $val->updated_at }}</td>
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
                        {{ $links->links() }}
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
                    <h4 class="modal-title">友情連結</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">連結名稱</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" placeholder="連結名稱">
                                    <input type="hidden" id="inputId" value="0">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputUrl" class="col-sm-2 control-label">連結網址</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputUrl" placeholder="連結網址">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputSort" class="col-sm-2 control-label">排序</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputSort" value="10" placeholder="排序">
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
            name = $("#inputName").val();
            url = $("#inputUrl").val();
            sort = $("#inputSort").val();
            id = $("#inputId").val();

            if(name.length <= 0 || url.length <= 0){
                $(".modal-message-body").html('名稱或URL不能為空');
                $("#modal-message").removeClass('modal-info').addClass('modal-danger').modal('show');
                return false;
            }
            $.post("{{ $webPath }}/link", { name: name,id:id,url:url,sort:sort },function(data){
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
                $(".modal-message-body").html('請選擇連結');
                $("#modal-message").removeClass('modal-info').addClass('modal-danger').modal('show');
                return false;
            }

            $.get( "{{ $webPath }}/link/" + id.id, function(data) {
                $("#inputName").val(data.data.name);
                $("#inputUrl").val(data.data.url);
                $("#inputSort").val(data.data.sort);
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
                url: '{{ $webPath }}/link/'+id.id,
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