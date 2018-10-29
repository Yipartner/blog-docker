@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <ul class="nav nav-pills nav-stacked col-md-2" style="border-right: darkgray solid 1px">
                <li role="presentation"><a href="{{url('/dashboard/type')}}">文章分类</a></li>
                <li role="presentation"><a href="#">标签管理</a></li>
                <li role="presentation"><a href="#">评论管理 <span class="badge">4</span></a></li>
            </ul>
            <div class="col-md-10">
                @yield('dc')
            </div>
        </div>
    </div>
@endsection
