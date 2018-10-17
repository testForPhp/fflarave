@extends('admin.layouts.common')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Bordered Table</h3>
                </div>
                <a type="button" class="btn btn-block btn-info" href="{{ $webPath }}/video/sort/create">添加分類</a>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>分類名稱</th>
                            <th>顯示首頁</th>
                            <th>父级</th>
                            <th>排序</th>
                            <th style="">操作</th>
                        </tr>
                        @foreach($sort as $val)
                        <tr>
                            <td>{{ $val->id }}</td>
                            <td>{{ $val->name }}</td>
                            <td>@if($val->is_home == 1)顯示 @else 不顯示 @endif</td>
                            <td>{{ $val->father_id }}</td>
                            <td>
                               {{ $val->sort }}
                            </td>
                            <td width="200">
                                <a type="button" class="btn btn-info" href="{{ $webPath }}/video/sort/{{ $val->id }}/edit">編輯</a>
                                <button type="button" data-id="{{ $val->id }}" class="btn btn-danger">刪除</button>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <ul class="pagination pagination-sm no-margin pull-right">
                        {{ $sort->links() }}
                    </ul>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
@endsection
@section('script')
<script>
    $(function () {
        $(".btn-danger").click(function () {
            id = $(this).data();
            _this = $(this);
            $.ajax({
               type: "delete",
               url: "{{ $webPath }}/video/sort/" + id.id,
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