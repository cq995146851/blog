@extends('layouts.app')
@section('title', '文章列表')
@section('content')
    <ul class="nav nav-tabs articles-nav">
        <li role="presentation" class="{{active_class(if_query('order', 'new') || if_query('order', ''))}}"><a href="{{Request::url()}}?order=new">最新发布</a></li>
        <li role="presentation" class="{{active_class(if_query('order', 'hot'))}}"><a href="{{Request::url()}}?order=hot">最热帖子</a></li>
        <li role="presentation" class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                 {{$curr_topic->name}}<span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                @foreach($topics as $topic)
                    @if($topic->id != $curr_topic->id)
                        <li><a href="{{route('articles.by_topic', $topic->id)}}">{{$topic->name}}</a></li>
                    @endif
                @endforeach
            </ul>
        </li>
    </ul>
    @include('common._articles_summary', compact('articles'))
@endsection