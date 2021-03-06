@extends('layouts.app')

@section('content')

    <div class="jumbotron "
         style="
    background-image: url({{config('app.home_picture_url')}});
    background-repeat: no-repeat;
    background-position: center 0;
    -webkit-background-size: cover;
    background-size: cover;
    padding: 138px 0 0;
    text-align: center;
    width: 100%;
    min-height: 800px;
    margin: 0px;
    /*position: relative*/
">
        <h1 style="cursor: pointer;color: #2a88bd"><a href={{url('/')}}>{{ config('app.home_name', 'MariaSeal\'s Pub') }}</a></h1>
        <h1 style="color: white"><span>{{ config('app.name', '小伙伴') }}</span></h1>
    </div>
@endsection
