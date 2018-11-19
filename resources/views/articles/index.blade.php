@extends('layouts.app')
@section('title', '文章列表')
@section('content')
    <ul class="nav nav-tabs articles-nav">
        <li role="presentation" class="{{active_class(if_query('order', 'new') || if_query('order', ''))}}"><a href="{{Request::url()}}?order=new">最新发布</a></li>
        <li role="presentation" class="{{active_class(if_query('order', 'hot'))}}"><a href="{{Request::url()}}?order=hot">最热帖子</a></li>
        <li role="presentation" class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                @if(empty($curr_topic))
                   全部
                @else
                    {{$curr_topic->name}}
                @endif
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="{{route('articles.by_topic', 0)}}"><strong>全部</strong></a></li>
                @foreach($topics as $topic)
                    <li><a href="{{route('articles.by_topic', $topic->id)}}">{{$topic->name}}</a></li>
                @endforeach
            </ul>
        </li>
    </ul>
    @if($articles->isNotEmpty())
        @include('common._articles_summary', compact('articles'))
    @else
        @include('common._no_content', ['content' => '未找到任何帖子'])
    @endif
@endsection