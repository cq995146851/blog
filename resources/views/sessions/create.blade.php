@extends('layouts.app')
@section('title', '登录')
@section('content')
    <div class="col-md-offset-2 col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">用户登录</h3>
            </div>
            <div class="panel-body">
                @include('common._error')
                <form action="{{route('sessions.store')}}" method="post" class="form-horizontal" role="form">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="" class="col-sm-2 col-sm-offset-2 control-label">邮箱</label>
                        <div class="col-sm-6">
                            <input type="email" name="email" value="{{old('email')}}" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 col-sm-offset-2 control-label">
                            密码
                        </label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <input type="password" name="password" class="form-control">
                                <span class="input-group-addon" id="reset_password" style="cursor: pointer">忘记密码?</span>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 col-sm-offset-2 control-label">验证码</label>
                        <div class="col-sm-4">
                            <input type="text" name="captcha" class="form-control">
                        </div>
                        <div class="col-sm-4">
                            <img src="{{captcha_src('flat')}}"
                                 onclick="this.src='{{captcha_src('flat')}}' + Math.random()">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-4">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember">记住我
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-4">
                            @include('common._submit_btn', ['content' => '登录'])
                        </div>
                    </div>
                </form>
                <div class="col-md-offset-4">
                    <p>还没有账号? 去 <a href="{{route('users.create')}}">注册->></a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('my-js')
    <script>
      $('#reset_password').click(function() {
        location.href = '{{route("password.create")}}'
      })
    </script>
@endsection