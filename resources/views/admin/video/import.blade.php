@extends('admin.layouts.common')
@section('content')
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Quick Example</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="{{ $webPath }}/video/import" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputFile">File input</label>
                        <input type="file" name="coding" id="exampleInputFile">
                        {{ csrf_field() }}
                        <p class="help-block">Example block-level help text here.</p>
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        <!-- /.box -->




    </div>
@stop