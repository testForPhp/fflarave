@extends('admin.layouts.common')
@section('style')
    <link rel="stylesheet" href="/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
@stop
@section('content')
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">添加通知</h3>
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
            <form class="form-horizontal" method="post" action="{{ $webPath }}/system/notify/create">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputTitle" class="col-sm-2 control-label">標題</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputTitle" name="title" value="@if(isset($notify)){{ $notify->title }}@endif" placeholder="標題">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputContent" class="col-sm-2 control-label">內容</label>

                        <div class="col-sm-10">

                <textarea class="textarea" placeholder="Place some text here"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="content">@if(isset($notify)){!! $notify->content !!}@endif</textarea>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="@if(isset($notify)){{ $notify->id }}@endif">
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
@section('script')
    <script src="/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <script>
        $('.textarea').wysihtml5()
    </script>
@stop