@extends('layouts.app')
@section('title', '文章列表')
@section('content')
    <ul class="nav nav-tabs articles-nav">
        <li role="presentation" class="{{active_class(!if_query('order', 'hot'))}}"><a href="{{Request::url()}}?order=new">最新发布</a></li>
        <li role="presentation" class="{{active_class(if_query('order', 'hot'))}}"><a href="{{Request::url()}}?order=hot">最热帖子</a></li>
    </ul>
    @include('common._articles_summary', compact('articles'))
@endsection