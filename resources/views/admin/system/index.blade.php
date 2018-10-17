@extends('admin.layouts.common')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">系統設置</h3>
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
                <form class="form-horizontal" method="post" action="">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputWebsite" class="col-sm-2 control-label">網站名稱</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="website" id="inputWebsite" placeholder="網站名稱" value="{{ isset($system->website) ? $system->website : '' }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputUrl" class="col-sm-2 control-label">網站地址</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="url" id="inputUrl" value="{{ isset($system->url) ? $system->url : '' }}" placeholder="網站地址">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail" class="col-sm-2 control-label">聯繫E-mail</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="email" value="{{ isset($system->email) ? $system->email : '' }}" id="inputEmail" placeholder="聯繫E-mail">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputImagesServer" class="col-sm-2 control-label">圖片服務器</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="imgServer" value="{{ isset($system->imgServer) ? $system->imgServer : '' }}" id="inputImagesServer" placeholder="圖片服務器">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputImagesServer" class="col-sm-2 control-label">LOGO</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="logo" value="{{ isset($system->logo) ? $system->logo : '' }}" id="inputLogo" placeholder="LOGO">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputImagesServer" class="col-sm-2 control-label">ads_1</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="ads_1" value="{{ isset($system->ads_1) ? $system->ads_1 : '' }}" id="inputAds1" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputImagesServer" class="col-sm-2 control-label">ads_1_link</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="ads_1_link" value="{{ isset($system->ads_1_link) ? $system->ads_1_link : '' }}" id="inputAds1" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputImagesServer" class="col-sm-2 control-label">ads_2</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="ads_2" value="{{ isset($system->ads_2) ? $system->ads_2 : '' }}" id="inputAds2" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputImagesServer" class="col-sm-2 control-label">ads_2_link</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="ads_2_link" value="{{ isset($system->ads_2_link) ? $system->ads_2_link : '' }}" id="inputAds2" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputCount" class="col-sm-2 control-label">網站統計</label>

                            <div class="col-sm-10">
                                <textarea class="form-control" rows="3" name="count" placeholder="網站統計">{{ isset($system->count) ? $system->count : '' }}</textarea>
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
        </div>
    </div>
@stop
