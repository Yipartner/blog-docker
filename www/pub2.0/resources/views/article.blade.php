@extends('layouts.app')

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="pane l-title">{{$article->title}}</h3>
            <div class="right" style="display: none">
                        <span id="busuanzi_container_page_pv">
  本文总阅读量<span id="busuanzi_value_page_pv"></span>次
</span>
        </div>
        <div class="panel-body" id="article_content">
            {!! $article->content !!}
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
    <div class="panel panel-default" style="text-align: right">
        <div class="panel-heading">
            <form action="{{}}" method="post">
                            <textarea class="form-control" rows="3"
                                      @if(Auth::guest())
                                      placeholder="请登录后评论" disabled
                                      @else
                                      placeholder="开始你的表演"
                                    @endif
                            ></textarea>
                <button type="submit" class="btn btn-primary" @if(Auth::guest()) disabled @endif>
                    发表评论
                </button>
            </form>
        </div>
        <div class="panel-body">

        </div>
    </div>

@endsection