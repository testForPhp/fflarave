@extends('home.layouts.common')
@section('content')
    <div class="container-fluid mt-4">
        <div class="row content-height">
            <div class="col-lg-2">
                <!-- menu -->
            @include('home.layouts.side')
            <!-- end menu -->
            </div>
            <div class="col-lg-1"></div>
            <div class="col-lg-9">
                <!-- content -->
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">儲值日期</th>
                                <th scope="col">儲值金額</th>
                                <th scope="col">購得點數</th>
                                <th scope="col">備註</th>
                                <th scope="col">消費狀態</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($payLog as $val)
                            <tr>
                                <th scope="row">{{ $val->created_at->format('Y-m-d H:i:s') }}</th>
                                <td>{{ $val->money }}</td>
                                <td>{{ $val->point }}點</td>
                                <td>{{ $val->summary }}</td>
                                <td>儲值成功</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                {{ $payLog->links() }}
                            </ul>
                        </nav>
                    </div>

                </div>
                <!-- end content -->
            </div>
        </div>
    </div>
@stop
