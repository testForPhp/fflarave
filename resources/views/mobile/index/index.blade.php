@extends('mobile.layouts.app')
@section('content')
    <!-- swiper -->
    <div class="swiper-container swiper-init demo-swiper">
        <div class="swiper-pagination"></div>
        <div class="swiper-wrapper">
            @foreach($banner as $val)
            <div class="swiper-slide">
                <a href="/mobile/v/{{ Hashids::encode($val->id) }}" class="external">
                    <img src="{{ $imgServer . $val->thumbnail }}" alt="{{ $val->name }}">
                </a>
            </div>
            @endforeach
        </div>
    </div>
    <!-- end swiper -->
    <!-- adv -->
    <div class="row adv">
        <div class="col-50">
            @if(isset(cache('system_base')->ads_1) && cache('system_base')->ads_1 != '')
            <a href="{{ cache('system_base')->ads_1_link }}" class="external">
                <img data-src="{{ cache('system_base')->ads_1 }}" alt="" class="lazy lazy-fade-in">
            </a>
            @endif
        </div>
        <div class="col-50">
            @if(isset(cache('system_base')->ads_2) && cache('system_base')->ads_2 != '')
                <a href="{{ cache('system_base')->ads_2_link }}" class="external">
                    <img data-src="{{ cache('system_base')->ads_2 }}" alt="" class="lazy lazy-fade-in">
                </a>
            @endif
        </div>
    </div>
    <!-- end adv -->
    <div class="row video-line">
        <div class="col-100">最熱視頻</div>
    </div>
    <div class="row video video-new">
        <!-- video -->

    </div>
@stop
@section('script')
<script>
    window.onload = function(){

        myApp.request.get('/mobile/host',{},function (e) {;
            $$(".video").html(videoListMart(e.data));
        },function (xhr) {},'json');

    }
</script>
@stop