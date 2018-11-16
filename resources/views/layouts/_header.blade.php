<header class="navbar navbar-fixed-top navbar-default">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="javascript:void(0)" onclick="javascript:history.go(-1)"><i class="fa fa-chevron-left"></i></a>
            <a class="navbar-brand" href="#">
                <img alt="Brand" src="{{asset('/images/blog.jpg')}}" with="25" height="25">
            </a>
            <a class="navbar-brand" href="{{route('articles.index')}}">星期八博客</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">

                @if(Auth::check())
                    <li><a href="{{route('articles.create')}}"><i class="fa fa-plus"></i>    新建帖子</a></li>
                    <li><a href="{{route('users.index')}}"><i class="fa fa-users"></i>    所有用户</a></li>
                    <li class="dropdown">
                        <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            @include('common._avatar', ['class' => 'avatar', 'user' => Auth::user()])
                            {{Auth::user()->name}}
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{route('users.show', Auth::id())}}">个人中心</a></li>
                            <li><a href="{{route('users.edit', Auth::id())}}">编辑资料</a></li>
                            <li><a href="{{route('users.reset_password')}}">修改密码</a></li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="javascript:void(0);">
                                    <form action="{{route('sessions.destroy', Auth::id())}}" method="post">
                                        {{csrf_field()}}
                                        {{method_field('DELETE')}}
                                        <button type="submit" class="btn btn-block btn-primary">退出</button>
                                    </form>
                                </a>
                            </li>
                        </ul>
                    </li>
                @else
                    <li><a href="{{route('users.create')}}"><i class="fa fa-edit"></i>    注册</a></li>
                    <li><a href="{{route('sessions.create')}}"><i class="fa fa-user"></i>    登录</a></li>
                @endif
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</header>