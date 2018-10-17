@extends('admin.layouts.common')
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">視頻分類添加</h3>
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
                <form role="form" action="{{ $webPath }}/video/sort/create" method="post">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">分類名稱</label>
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   id="exampleInputName"
                                   @if(isset($sort->name))
                                           value="{{ $sort->name }}"
                                   @endif
                                   placeholder="請輸入視頻名稱">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFather">父级</label>
                            <select class="form-control" name="father_id">
                                <option value="0">==顶级==</option>
                                @foreach($sortAll as $val)
                                    <option value="{{ $val->id }}" @if(isset($sort) && $sort->father_id == $val->id) selected @endif>{{ $val->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">排序</label>
                            <input type="text"
                                   class="form-control"
                                   name="sort"
                                   id="exampleInputPassword1"
                                   @if(isset($sort->sort))
                                           value="{{ $sort->sort }}"
                                   @else
                                            value="0"
                                   @endif
                                   placeholder="排序">
                            @if(isset($sort->id))
                                <input type="hidden" name="id" value="{{ $sort->id }}">
                            @endif
                        </div>
                        <div class="form-group">
                            <label>
                                是否顯示在首頁 <input type="checkbox" name="is_home" value="1" @if(isset($sort->is_home) && $sort->is_home == 1) checked @endif>
                            </label>
                        </div>
                       {{ csrf_field() }}
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
@endsection