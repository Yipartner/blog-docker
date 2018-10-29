<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
{{--<link href="/css/app.css" rel="stylesheet">--}}
<!-- Scripts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="{{url('/')}}/js/bootstrap.min.js"></script>
    <script src="https://cdn.bootcss.com/marked/0.4.0/marked.js"></script>
    <srcipt src="{{url('/')}}/js/Parser.js"></srcipt>
    <script async src="//busuanzi.ibruce.info/busuanzi/2.3/busuanzi.pure.mini.js">
    </script>
    <script>
        window.Laravel = '{{json_encode([
            'csrfToken' => csrf_token(),
        ])}}'
    </script>
    {{--<script src="/js/app.js"></script>--}}
</head>
<body>
<div id="app" style="background-color: white" class="container">

    <nav class="navbar navbar-default navbar-static-top" style="margin: 0 0 2px 0">

        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/home') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                &nbsp;<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                       aria-expanded="false" aria-haspopup="true">
                        博文 <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        @inject('typeService','App\Services\TypeService)
                        @foreach($typeService->showTypes() as $type)
                            <li>
                                <a href={{url('/article/type/'.$type->id)}}>{{$type->name}}</a>
                            </li>
                        @endforeach

                    </ul>
                </li>
                <li>
                    <a href="http://she.sealbaby.cn">
                        她
                    </a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">登录</a></li>
                    <li><a href="{{ url('/register') }}">注册</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            @if(Auth::user()->is_admin)
                                <li><a href="{{ url('/article/create') }}">写文章</a></li>
                                <li><a href="{{ url('/dashboard') }}">管理</a></li>
                            @endif
                            <li>
                                <a href="{{ url('/logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    登出
                                </a>

                                <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>

                        </ul>
                    </li>
                @endif
            </ul>
        </div>

    </nav>
    @yield('content')
    <div class="footer">
        <div style="display:none">
            <span id="busuanzi_container_site_pv">
    本站总访问量<span id="busuanzi_value_site_pv"></span>次
</span>
        </div>
    </div>

    <!-- Scripts -->

</body>
</html>
