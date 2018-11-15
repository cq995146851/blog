@extends('layouts.app')
@section('title', '编辑资料')
@section('content')
    <div class="col-sm-offset-2 col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">编辑资料</h3>
            </div>
            <div class="panel-body">
                @include('common._error')
                <form action="{{route('users.update', Auth::id())}}" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                    {{csrf_field()}}
                    {{method_field('PUT')}}
                    <div class="form-group">
                        <label for="" class="col-sm-2 col-md-offset-2 control-label">用户名</label>
                        <div class="col-sm-6">
                            <input type="text" name="name" value="{{old('name', $user->name)}}" class="form-control" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-2 col-md-offset-2 control-label">邮箱</label>
                        <div class="col-sm-6">
                            <input type="email" name="email" value="{{old('email', $user->email)}}" class="form-control"  readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-2 col-md-offset-2 control-label">头像</label>
                        <div class="col-sm-6">
                            <input type="file" name="avatar" value="{{old('name', $user->name)}}" class="form-control" >
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-4">
                           @include('common._submit_btn', ['content' => '修改'])
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection