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
                            @if($user->avatar)
                                <img class="avatar" src="{{$user->avatar}}" alt="{{$user->name}}">
                            @else
                                <img class="avatar" src="{{asset('/images/noimg.jpg')}}" alt="{{$user->name}}">
                            @endif
                            {{$user->name}}
                            <span class="badge">12粉丝</span>
                        </a>
                    @endforeach
                </div>
            </div>

            {{  $users->links() }}
        </div>
    </div>
    </div>
@endsection