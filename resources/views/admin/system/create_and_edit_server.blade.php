@extends('admin.layouts.common')
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">伺服器添加</h3>
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
                <form role="form" action="{{ $webPath }}/system/server/create" method="post">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">伺服器名稱</label>
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   id="exampleInputName"
                                   @if(isset($server->name))
                                   value="{{ $server->name }}"
                                   @endif
                                   placeholder="請輸入伺服器名稱">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">伺服器地址</label>
                            <input type="text"
                                   class="form-control"
                                   name="site"
                                   id="exampleInputPassword1"
                                   @if(isset($server->site))
                                   value="{{ $server->site }}"
                                   @endif
                                   placeholder="伺服器地址">
                            @if(isset($server->id))
                                <input type="hidden" name="id" value="{{ $server->id }}">
                            @endif
                        </div>
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-sm-offset-0 col-sm-10">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="is_active" value="1" {{ isset($server->is_active) && $server->is_active == 1 ? 'checked' : '' }}> 是否啟用
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">提交</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (left) -->

    </div>
@stop