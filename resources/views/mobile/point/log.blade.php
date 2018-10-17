@extends('mobile.layouts.app')
@section('content')
    <div class="list text-color-gray" style="margin-top: 0;font-size: 11px;">
        <ul>
            @foreach($log as $value)
            <li>
                <a href="#" class="item-link item-content">
                    <div class="item-inner" style="background-image:url()">
                        <div class="item-title">
                            <div class="item-header text-color-black" style="font-size: 17px;">{{ $value->money }}元</div>
                            | <span class="margin-right-03">{{ $value->summary }}</span>{{ $value->created_at->format('Y-m-d') }}
                        </div>
                        <div class="item-after text-color-red">+{{ $value->point }}點</div>
                    </div>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
    @if($log->lastPage() > 1)
    <div class="paginate block">
        <div class="row">
            <div class="col-50">
                <a class="col button button-small up-page external" href="/mobile/member/pointlog/?page=@if(($log->currentPage() - 1) <= 1)1 @else {{ $log->currentPage() - 1 }} @endif">上一頁</a>
            </div>
            <div class="col-50">
                <a class="col button button-small next-page external" href="@if($log->currentPage() >= $log->lastPage()) # @else /mobile/member/pointlog/?page={{$log->currentPage() + 1}} @endif">下一頁</a>
            </div>
        </div>
    </div>
    @endif
@stop