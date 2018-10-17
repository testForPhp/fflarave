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
                            <th>Email</th>
                            <th>Point</th>
                            <th>方案</th>
                            <th>截止日期</th>
                            <th>註冊時間</th>
                            <th>登陸時間</th>
                        </tr>
                        @foreach($user as $val)
                            <tr>
                                <td>{{ $val->id }}</td>
                                <td>{{ $val->name }}</td>
                                <td>{{ $val->email}}</td>
                                <td>{{ $val->point}}</td>
                                <td>@if($val->is_vip == 1)是 @else 不是 @endif</td>
                                <td>@if($val->vip_end_time == '') -- @else {{ $val->vip_end_time }} @endif</td>
                                <td>{{ $val->created_at->format('Y-m-d H:i:s') }}</td>
                                <td>{{ $val->updated_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <ul class="pagination pagination-sm no-margin pull-right">
                        {{ $user->links() }}
                    </ul>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
@stop