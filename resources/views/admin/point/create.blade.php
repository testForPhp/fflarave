@extends('admin.layouts.common')
@section('content')
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">添加方案</h3>
            </div>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
        @endif
        <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="{{ $webPath }}/point/create">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputTitle" class="col-sm-2 control-label">名稱</label>

                        <div class="col-sm-10">
                            <input type="text" name="title" class="form-control" id="inputTitle" placeholder="名稱" value="@if(isset($info)){{ $info->title }} @endif">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSummary" class="col-sm-2 control-label">簡介</label>

                        <div class="col-sm-10">
                            <input type="text" name="summary" class="form-control" id="inputSummary" placeholder="簡介" value="@if(isset($info)){{ $info->summary }} @endif">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputTime" class="col-sm-2 control-label">點數</label>

                        <div class="col-sm-10">
                            <input type="text" name="point" value="@if(isset($info)){{ $info->point }}@else 0 @endif" class="form-control" id="inputTime" placeholder="點數">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputTotal" class="col-sm-2 control-label">價格</label>

                        <div class="col-sm-10">
                            <input type="text" name="money" class="form-control" id="inputTotal" placeholder="價格" value="@if(isset($info)){{ $info->money }} @endif">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputLink" class="col-sm-2 control-label">連結</label>

                        <div class="col-sm-10">
                            <input type="text" name="link" class="form-control" id="inputLink" placeholder="連結" value="@if(isset($info)){{ $info->link }} @endif">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSort" class="col-sm-2 control-label">排序</label>

                        <div class="col-sm-10">
                            <input type="text" name="sort" class="form-control" id="inputSort" placeholder="排序" value="@if(isset($info)){{ $info->sort }} @else 0 @endif">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="@if(isset($info)){{ $info->id }} @endif">
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="reset" class="btn btn-default">Reset</button>
                    <button type="submit" class="btn btn-info pull-right">Submit</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
        <!-- /.box -->
    </div>
@stop