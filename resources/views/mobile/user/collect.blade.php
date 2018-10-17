@extends('mobile.layouts.app')
@section('content')
    <div class="list" style="margin-top: 0">
        <ul>
            @foreach($video as $value)
            <li>
                <div class="item-link item-content">
                    <div class="item-media">
                        <a href="/mobile/v/{{ Hashids::encode($value->id) }}" class="external"><img data-src="{{ $imgServer . $value->thumbnail }}" class="lazy lazy-fade-in" width="80"/></a>
                    </div>
                    <div class="item-inner" style="background-image:url();padding-right:10px;">
                        <div class="item-title"><a href="/mobile/v/{{ Hashids::encode($value->id) }}" class=" external">{{ $value->name }}</a></div>
                        <div class="item-after">
                            <button class="col button button-fill color-red button-round" data-token="{{ Hashids::encode($value->id) }}">刪除</button>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
    @if($video->lastPage() > 1)
        <div class="paginate block">
            <div class="row">
                <div class="col-50">
                    <a class="col button button-small up-page external" href="/mobile/member/notice/?page=@if(($video->currentPage() - 1) <= 1)1 @else {{ $video->currentPage() - 1 }} @endif">上一頁</a>
                </div>
                <div class="col-50">
                    <a class="col button button-small next-page external" href="@if($video->currentPage() >= $video->lastPage()) # @else /mobile/member/notice/?page={{$video->currentPage() + 1}} @endif">下一頁</a>
                </div>
            </div>
        </div>
    @endif
@stop
@section('script')
<script>
    $$(".button-fill").on('click',function () {
        myApp.preloader.show();
        let token = $$(this).data('token');
        let $$_this = $$(this);

        if(token == ''){
            myApp.preloader.hide();
            myApp.dialog.alert('請選擇視頻');
            return false;
        }
        myApp.request({
            method:'DELETE',
            dataType:'json',
            url:'/member/collect/' + token,
            data:{},
            success:function (data) {
                $$_this.parent().parent().parent().parent().remove()
                notifications('刪除成功！',data.message).open();
            },
            error:function (xhr) {
                myApp.dialog.alert(errorJsonToText(JSON.parse(xhr.response)));
            },
            complete:function (xhr) {
                myApp.preloader.hide();
            }
        });
    });
</script>
@stop