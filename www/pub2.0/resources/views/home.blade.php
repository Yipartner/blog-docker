@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">


            @if(json_decode(json_encode($articles))->data!=[])
                @foreach($articles as $article)
                    {{--<img class="visible-lg" src="http://picture.sealbaby.cn/404.jpg" style="float: left;margin: 0.7%;margin-right: 10px" width="26%">--}}
                    <div class="panel panel-default">

                        <div class="panel-heading">
                            <h4>
                                <a style="cursor: pointer;"
                                   onclick="window.location.href='{{url('/article/content/'.$article->id)}}'">{{$article->title}}</a>
                                @if(!Auth::guest())
                                    @if(Auth::user()->is_admin)
                                        <form name="deleteForm" id="deleteForm" action="{{url('/article/delete/'.$article->id)}}" method="get" style="float: right">
                                            <a style="cursor: pointer" class="pull-right" onclick="document.getElementById('deleteForm').submit();" >&nbsp;删除</a>
                                        </form>
                                        {{--<a href="{{url('/article/delete/'.$article->id)}}"--}}
                                           {{--class="pull-right">&nbsp;删除</a>--}}
                                        <a href="{{url('/article/edit/'.$article->id)}}" class="pull-right">编辑</a>
                                    @endif
                                @endif
                            </h4>
                        </div>
                        <div class="panel-collapse" style="margin:2%;">
                            &ensp;&ensp;&ensp; {{$article->content}}
                        </div>
                        <div class="panel-footer">
                            @if($article->tags)
                                @foreach($article->tags as $tag)
                                    <button class="btn-sm" style="background-color: {{$tag['color']}}"
                                            onclick="window.location.href='{{url('/article/tag/'.$tag['tag_id'])}}'">
                                        <span style="font-weight:500;color: white">{{$tag['name']}}</span>
                                    </button>
                                @endforeach
                            @else
                                <button class="btn" disabled="true">暂无标签</button>
                            @endif
                        </div>
                    </div>
                @endforeach
                {{$articles->links('vendor.pagination.bootstrap-4')}}
            @else
                <div style="text-align: center; margin-top: 30px">
                    <img src="http://picture.sealbaby.cn/404%E5%BD%A9.png" width="50%" alt="">
                    <h3>小伙伴还没有该分类的文章</h3>
                    <h3>你可以去看看其他类别下的文章~~</h3>
                </div>
            @endif

        </div>
    </div>
@endsection
