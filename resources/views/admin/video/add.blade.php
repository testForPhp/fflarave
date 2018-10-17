@extends('admin.layouts.common')
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">視頻添加</h3>
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
                <form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{ $webPath }}/video/create">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">視頻名稱</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputName" name="name" placeholder="視頻名稱">
                            </div>
                            <label for="inputPixel" class="col-sm-2 control-label">清晰度</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="inputPixel" name="pixel">
                                    @foreach($baseData['pointData'] as $key=>$val)
                                    <option value="{{ $key }}">{{ $val }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputSort" class="col-sm-2 control-label">分類</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="inputSort" name="sort">
                                    @foreach($baseData['sort'] as $val)
                                    <option value="{{ $val->id }}">{{ $val->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="inputRegion" class="col-sm-2 control-label">地區</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="inputRegion" name="region">
                                    @foreach($baseData['city'] as $key=>$val)
                                    <option value="{{ $key }}">{{ $val }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputIsVip" class="col-sm-2 control-label">是否收費</label>
                            <div class="col-sm-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="is_vip" value="1">是
                                    </label>
                                </div>
                            </div>
                            <label for="inputPoint" class="col-sm-2 control-label">點播點數</label>
                            <div class="col-sm-4">
                                <input type="text" name="point" class="form-control" id="inputPoint">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputTimeLimit" class="col-sm-2 control-label">時長</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputTimeLimit" name="time_limit" placeholder="時長">
                            </div>
                            <label for="inputTimeLimit" class="col-sm-2 control-label">推薦到輪播圖</label>
                            <div class="col-sm-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="is_banner" value="1">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputTags" class="col-sm-2 control-label">標籤</label>
                            <div class="col-sm-10">
                                <select multiple class="form-control" id="inputTags" name="tags[]">
                                    @foreach($baseData['tags'] as $val)
                                    <option value="{{ $val->id }}">{{ $val->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputTags" class="col-sm-2 control-label">封面</label>
                            <div class="col-sm-10">
                                <input type="file" name="thumbnail" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPreview" class="col-sm-2 control-label">预览地址</label>
                            <div class="col-sm-10">
                                <input type="text" name="preview" class="form-control" id="inputPreview">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputLink" class="col-sm-2 control-label">視頻地址</label>
                            <div class="col-sm-10">
                                <input type="text" name="link" class="form-control" id="inputLink">
                                {{ csrf_field() }}
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
        <!--/.col (left) -->

    </div>
@endsection