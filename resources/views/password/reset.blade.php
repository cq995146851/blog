@extends('layouts.app')
@section('title', '密码重置')
@section('content')
    <div class="col-md-offset-2 col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">密码重置</h3>
            </div>
            <div class="panel-body">
                @include('common.error')
                <form action="{{route('password.save')}}" method="post" class="form-horizontal" role="form">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="" class="col-sm-2 col-sm-offset-2 control-label">邮箱</label>
                        <div class="col-sm-6">
                            <input type="email" name="email" value="{{$email}}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 col-sm-offset-2 control-label">密码</label>
                        <div class="col-sm-6">
                            <input type="password" name="password" class="form-control" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 col-sm-offset-2 control-label">确认密码</label>
                        <div class="col-sm-6">
                            <input type="password" name="password_confirmation" class="form-control" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 col-sm-offset-2 control-label">验证码</label>
                        <div class="col-sm-4">
                            <input type="text" name="captcha" class="form-control" >
                        </div>
                        <div class="col-sm-4">
                            <img src="{{captcha_src('flat')}}"
                                 onclick="this.src='{{captcha_src('flat')}}' + Math.random()">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-4">
                            <button type="button" class="btn btn-primary" onclick="this.disabled=true; this.innerHTML='修改中...'; this.form.submit();">
                                确认
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection