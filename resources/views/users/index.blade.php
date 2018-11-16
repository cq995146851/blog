@extends('layouts.app')
@section('title', '用户列表')
@section('content')
    <div class="col-sm-offset-1 col-sm-10">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">所有用户</h3>
            </div>
            <div class="panel-body">
                <div class="list-group">
                    @foreach($users as $user)
                        <a href="{{route('users.show', $user->id)}}" class="list-group-item">
                           @include('common._avatar', ['class' => 'avatar', 'user' => $user])
                            {{$user->name}}
                            <span class="badge">{{$user->followers_count}}个粉丝</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="text-center">
                {{  $users->links() }}
            </div>
        </div>
    </div>
    </div>
@endsection