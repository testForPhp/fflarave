@extends('mobile.layouts.app')
@section('content')
    <div class="row video video-new">
        <!-- video -->
        @foreach($sort['result'] as $val)
        <div class="card demo-facebook-card">
            <div class="card-header">
                <div class="demo-facebook-name">{{ $val->name }}</div>
                <div class="demo-facebook-date">{{ $val->updated_at->format('Y-m-d') }}</div>
            </div>
            <div class="card-content">
                <a href="/mobile/v/{{ Hashids::encode($val->id) }}" class="external"><img data-src="{{ $imgServer . $val->thumbnail }}" class="lazy lazy-fade-in" width="100%"/></a>
            </div>
            <div class="card-footer">
                <a href="#" class="link">
                    <i class="f7-icons diy-size-20">timer_fill</i>
                    {{ $val->time_limit }}
                </a>
                <a href="#" class="link">
                    <i class="f7-icons diy-size-20">videocam_round_fill</i>
                    {{ $val->pointData()[$val->pixel] }}
                </a>
                <a href="#" class="link">
                    <i class="f7-icons diy-size-20">eye_fill</i>
                    {{ $val->view + $val->click }}
                </a>
            </div>
        </div>
        @endforeach
    </div>
    <div class="paginate block">
        <div class="row">
            <div class="col-30">
                <button class="col button button-small up-page">上一頁</button>
            </div>
            <div class="col-40">
                <select name="gender" class="video-mune-select">
                </select>
            </div>
            <div class="col-30">
                <button class="col button button-small next-page">下一頁</button>
            </div>
        </div>
    </div>
@stop
@section('script')
<script>
let total = parseInt({{ $sort['count'] }});
let limit = parseInt({{ $sort['limit'] }});
let current_page = parseInt({{ $page }});
let token = "{{ $sort['token'] }}";

window.onload = function () {
    let page = Math.ceil(total / limit);

    $$(".video-mune-select").append(pageHtml());

    $$(document).on('change','.video-mune-select',function (e) {
            jumpUrl($$(this).val());
    });

    $$(".up-page").on('click',function (e) {
        if(current_page <= 1){
            myApp.dialog.alert('已經是第一頁了！');
            return false;
        }
        jumpUrl(current_page - 1);
    });

    $$(".next-page").on('click',function (e) {
        if(current_page >= page){
            myApp.dialog.alert('已經是第後一頁了！');
            return false;
        }
        jumpUrl(current_page + 1);
    });

    function jumpUrl(id)
    {
        return window.location.href = '/mobile/list/' + token + '/?page=' + id;
    }
    function pageHtml()
    {
        _html = '';
        for (i=1; i <= page; i++){

            if(current_page == i){
                _html += '<option value="'+ i +'" selected>第'+ i +'頁</option>';
            }else{
                _html += '<option value="'+ i +'">第'+ i +'頁</option>';
            }
        }
        return _html;
    }

}
</script>
@stop