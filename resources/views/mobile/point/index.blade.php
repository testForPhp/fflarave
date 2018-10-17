@extends('mobile.layouts.app')
@section('content')
    <div class="card" style="margin-left: 0;margin-right: 0;">
        <div class="card-header text-color-blue">
            <span class="f7-icons">more_vertical_round_fill儲值說明</span>
        </div>
        <div class="card-content card-content-padding text-color-gray">
            <p>1、在"儲值點數"選擇需要儲值的點數，然後點擊"前往支付"，之後會打開一個新的頁面，請在該頁面進行支付，支付完成後會得到一個激活嗎！</p>
            <p>2、將第一步得到的激活嗎複製到"點數兌換"裡面點擊"提交"，就完成儲值！</p>
        </div>
    </div>
    <div class="card" style="margin-right: 0;margin-left: 0;">
        <div class="card-header text-color-blue">
            <span class="f7-icons">card_fill點數兌換</span>
        </div>
        <div class="card-content padding-bottom-10-px">
            <dir class="row">
                <div class="col-70">
                    <input type="text" id="code" placeholder="請輸入您的激活嗎" style="border-bottom: 1px solid #999;line-height: 31px;padding-bottom: 5px; width: 100%;font-size: 20px;">
                </div>
                <div class="col-30" style="padding-right:0.3em;">
                    <button class="col button button-big button-fill put-active-code">提交</button>
                </div>
            </dir>
        </div>
    </div>

    <div class="card" style="margin-right: 0;margin-left: 0;">
        <div class="card-header text-color-blue">
            <span class="f7-icons">keyboard_fill儲值點數</span>
        </div>
        <div class="card-content list">
            <ul>
                @foreach($point as $key=>$value)
                <li>
                    <label class="item-radio item-content">
                        <input type="radio" name="link" value="{{ $value->link }}" @if($key == 0)checked @endif />
                        <i class="icon icon-radio"></i>
                        <div class="item-inner">
                            <div class="item-title">
                                <div class="item-header">
                                    {{ $value->title }}
                                </div>
                                {{ $value->summary }}
                            </div>
                            <div class="item-after">{{ $value->money }}元</div>
                        </div>
                    </label>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="card-footer" style="text-align: center;">
            <a class="col button button-fill external block play-put" target="_blank" href="{{ env('PLAY_PREFIX_URL') . $point[0]->link }}">前往支付</a>
        </div>
    </div>
@stop
@section('script')
<script>
    let jump = "{{ env('PLAY_PREFIX_URL') }}";
    $$("input[type=radio][name=link]").on('change',function () {
        let link = $$(this).val();
        if(link == ''){
            myApp.dialog.alert('請選擇儲值點數！');
            return false;
        }
        $$(".play-put").attr('href',jump + link);
    });

    $$(".put-active-code").on('click',function () {
        myApp.preloader.show();
        let code = $$("#code").val();
        if(code == ''){
            myApp.preloader.hide();
            myApp.dialog.alert('請輸入激活嗎');
            return false;
        }
        if(code.length < 6){
            myApp.preloader.hide();
            myApp.dialog.alert('激活嗎不能少於6位');
            return false;
        }
        myApp.request.post('/member/point',{code:code},function (e) {
            myApp.preloader.hide();
            notifications('儲值成功',e.message).open();
        },function (xhr) {
            myApp.preloader.hide();
            myApp.dialog.alert(errorJsonToText( JSON.parse(xhr.response)));
        },'json');
    });
</script>
@stop