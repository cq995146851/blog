@extends('layouts.app')
@section('title', '密码找回')
@section('content')
    <div class="col-md-offset-2 col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">密码找回</h3>
            </div>
            <div class="panel-body">
                @include('common._error')
                <form action="{{route('password.store')}}" method="post" class="form-horizontal" role="form">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="" class="col-sm-2 col-sm-offset-2 control-label">邮箱</label>
                        <div class="col-sm-6">
                            <input type="email" name="email" value="{{old('email')}}" class="form-control" >
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
                            @include('common._submit_btn', ['content' => '发送邮件'])
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection