@extends('mobile.layouts.app')
@section('content')
    <!-- video -->
    <div class="list notice-list" style="margin-top: 0">
        <ul>
            @foreach($notice as $value)
            <li>
                <div class="item-link item-content popup-open" data-token="{{ Hashids::encode($value->id) }}" data-popup=".popup-about">
                    <div class="item-inner">
                        <div class="item-title">{{ $value->title }}</div>
                        <div class="item-after">{{ $value->created_at->format('Y-m-d') }}</div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
    @if($notice->lastPage() > 1)
        <div class="paginate block">
            <div class="row">
                <div class="col-50">
                    <a class="col button button-small up-page external" href="/mobile/member/notice/?page=@if(($notice->currentPage() - 1) <= 1)1 @else {{ $notice->currentPage() - 1 }} @endif">上一頁</a>
                </div>
                <div class="col-50">
                    <a class="col button button-small next-page external" href="@if($notice->currentPage() >= $notice->lastPage()) # @else /mobile/member/notice/?page={{$notice->currentPage() + 1}} @endif">下一頁</a>
                </div>
            </div>
        </div>
    @endif
    <!-- end video -->
    <div class="popup popup-about">
        <div class="block">
            <p class="title">About</p>
            <!-- Close Popup -->
            <p><a class="link popup-close" href="#">關閉窗口</a></p>
            <p class="msg-content">Lorem ipsum dolor sit amet...</p>
        </div>
    </div>
@stop
@section('script')
<script>
    var dynamicPopup = myApp.popup.create({
        el:'.popup-about',
        on: {
            open: function (popup) {
                console.log('Popup open');
            },
            opened: function (popup) {
                console.log('Popup opened');
            },
        }
    });

    $$('.item-content').on('click',function () {
        myApp.preloader.show();
        let token = $$(this).data('token');
        myApp.request.get('/member/notify/'+token,{},function (e) {
            myApp.preloader.hide();
            $$(".title").text(e.data.title);
            $$(".msg-content").html(e.data.content);
            dynamicPopup.open();
        },function (xhr) {
            myApp.preloader.hide();
            myApp.dialog.alert(errorJsonToText( JSON.parse(xhr.response)));
        },'json');
    });
</script>
@stop