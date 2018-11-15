@extends('layouts.app')
@section('title', $user->name . '的个人中心')
@section('content')
    <div class="col-sm-12 text-center">
        <img class="img-responsive bigger-avatar" src="{{$user->avatar}}" alt="{{$user->name}}">
        <h2>{{$user->name}}</h2>
    </div>
    <div class="col-sm-12 text-center user-info">
        <a href="#">
            <strong>3</strong>关注
        </a>
        <a href="#">
            <strong>3</strong>粉丝
        </a>
        <a href="#">
            <strong>{{$user->articles_count}}</strong>文章
        </a>
    </div>
    <div class="col-sm-12 text-center follow-btn">
        @if(Auth::id() != $user->id)
            @include('common._follow_btn')
        @endif
    </div>
    <div class="col-sm-12">
        @if($articles->isNotEmpty())
            @include('common._articles_summary', compact('articles'))
        @else
            @include('common._no_content', ['content' => '暂没有发布帖子哦'])
        <div class="text-center">
            <a href="{{route('articles.create')}}" class="btn btn-primary">去发布</a>
        </div>
        @endif
    </div>
@endsection