@extends('admin.layouts.common')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">檢舉列表</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>用戶名</th>
                            <th>視頻名稱</th>
                            <th>時間</th>
                        </tr>
                        @foreach($reflect as $val)
                            <tr>
                                <td>{{ $val->id }}</td>
                                <td>{{ $val->user->name }}</td>
                                <td>{{ $val->video->name }}</td>
                                <td>{{ $val->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <ul class="pagination pagination-sm no-margin pull-right">
                        {{ $reflect->links() }}
                    </ul>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
@stop