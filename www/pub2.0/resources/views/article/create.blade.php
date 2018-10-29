@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="/css/bootstrap-tagsinput.css">
    <div class="row" style="margin: 0;">
        <div class="input-group">
            <input class="input-lg form-control" placeholder="请输入文章标题" id="title" type="text"
                   value="{{$article->title ?? ''}}">
            <div class="input-group-btn dropdown">
                <button type="button" class="btn btn-lg btn-primary dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="true">发布 <span class="caret"></span></button>
                <div class="dropdown-menu dropdown-menu-right" style="min-width: 300px" id="dropdown">
                    <script>
                        $("#dropdown").click(function (e) {
                            console.log("阻止下拉栏收回");
                            e.stopPropagation();m

                        })
                    </script>
                    <div class="panel panel-default">
                        <div class="panel-heading">发布文章</div>
                        <div class="panel-body">
                            <p>选择分类</p>
                            @inject('typeService','App\Services\TypeService)
                            <select multiple id="type" class="form-control">
                                @foreach($typeService->showTypes() as $type)
                                    <option value="{{$type->id}}" {{($article->type_id ?? 1) ==$type->id ?'selected': ''}}>{{$type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="panel-heading">
                            标签
                        </div>
                        <div class="panel-body">
                            <div id="tags-parent">
                                <input value="{{isset($article->tags[0])?','.$article->tags[0]['name']:'' }}{{isset($article->tags[1])?','.$article->tags[1]['name']:'' }}{{isset($article->tags[2])?','.$article->tags[2]['name']:'' }}"
                                       data-role="tagsinput" style="width: 270px" type="text" id="tags-sel">
                            </div>
                        </div>
                        <div class="panel-heading">
                            状态
                        </div>
                        <div class="panel-body">
                            <label class="radio-inline">
                                <input type="radio" name="articleStatus" id=""
                                       value="0" {{ ($article->status??1)==0?'checked':'' }}> 草稿
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="articleStatus" id=""
                                       value="1" {{ ($article->status??1)==1?'checked':'' }}> 公开发布
                            </label>
                            <label class="radio-inline disabled">
                                <input type="radio" name="articleStatus" id="" value="2" disabled> 指定人可见
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="articleStatus" id=""
                                       value="3" {{ ($article->status??1)==3?'checked':'' }}> 仅自己可见
                            </label>
                        </div>
                        <div class="panel-footer" style="text-align: center">
                            <button class="btn btn-primary" id="submit" type="submit"> 确认并发布</button>
                            <script>
                                $("#submit").click(function () {
                                    console.log("click");
                                    @if($do == 'create')
                                    submitArticle();
                                    @else
                                    editArticle();
                                    @endif
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 " style="padding: 0;overflow: auto">
            <textarea class="form-control" style="resize: none;font-size: large;padding: 20px;"
                      id="content"
                      oninput="contentChange(this)"
            >{{$article->content ?? ''}}</textarea>
            <script>
                function contentChange(that) {
                    console.log(that.value);
                    document.getElementById('pre').innerHTML = marked(that.value)
                }
            </script>
        </div>
        <div class="col-md-6" style="overflow: auto;padding: 0">
            <div style="width: 100%;height:200px; padding: 20px;border-radius: 2px;border: lightgray solid 1px"
                 id="pre"></div>
        </div>
        {{--</form>--}}
    </div>

    <nav class="nav navbar-fixed-bottom" style="overflow: hidden" id="dibu">
            <div class="container">
            <div class="col-md-6" style="border: lightgray solid 1px">
                <span class="text-left" style="font-size:30px;color: darkgray">MarkDown</span>
            </div>
            <div class="col-md-6" style="border: lightgray solid 1px">
                <span class="text-left" style="font-size:30px;color: darkgray">预览</span>
            </div>
        </div>
    </nav>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
    <script src="/js/bootstrap-tagsinput.js"></script>
    <script>
        function getArticle() {
            var title = document.getElementById('title').value;
            var content = document.getElementById('content').value;
            var type_id = $('#type option:selected').val();
            var tags = $('#tags-sel').tagsinput('items');
            var status = $('input:radio[name=articleStatus]:checked').val();
            return {
                title: title,
                content: content,
                type_id: type_id,
                tags: tags,
                status: status
            }
        }

        function submitArticle() {
            var article = getArticle();
            $.post("{{url('/article')}}", article,function (res) {
                window.location.href= res;
            })
        }

        function editArticle() {
            var article = getArticle();
            article.id = Number('{{$article->id??1}}');
            $.post("{{url('/article/edit')}}", article,function (res) {
                window.location.href= res;
            })

        }

        $(window).resize(function () {
            document.getElementById('content').style.height = document.getElementById('dibu').getBoundingClientRect().top - document.getElementById('title').getBoundingClientRect().bottom + 'px';
            document.getElementById('pre').style.height = document.getElementById('dibu').getBoundingClientRect().top - document.getElementById('title').getBoundingClientRect().bottom + 'px';
        });
        document.getElementById('pre').style.height = document.getElementById('dibu').getBoundingClientRect().top - document.getElementById('title').getBoundingClientRect().bottom + 'px';
        document.getElementById('content').style.height = document.getElementById('dibu').getBoundingClientRect().top - document.getElementById('title').getBoundingClientRect().bottom + 'px';
        document.getElementById('pre').innerHTML = marked(document.getElementById('content').value);
        $(function () {
            $('#tags-sel').on('change', function (event) {
                var $element = $(event.target),
                    $container = $element.closest('.example');

                if (!$element.data('tagsinput'))
                    return;

                var val = $element.val();
                if (val === null)
                    val = "null";
                $('code', $('pre.val', $container)).html(($.isArray(val) ? JSON.stringify(val) : "\"" + val.replace('"', '\\"') + "\""));
                $('code', $('pre.items', $container)).html(JSON.stringify($element.tagsinput('items')));
            }).trigger('change');
        });
        var citynames = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: {
                url: '{{url('/tags')}}',
                cache: false,
                filter: function (list) {
                    return $.map(list, function (cityname) {
                        return {name: cityname};
                    });
                }
            }
        });
        citynames.initialize();
        console.log(citynames.ttAdapter());

        /**
         * Typeahead
         */
        var elt = $('#tags-sel');
        elt.tagsinput({
            typeaheadjs: {
                name: 'citynames',
                displayKey: 'name',
                valueKey: 'name',
                source: citynames.ttAdapter()
            },
            maxTags: 3
        });


        $(".twitter-typeahead").css('display', 'inline');

    </script>


@endsection