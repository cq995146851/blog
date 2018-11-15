@extends('layouts.app')
@section('title', '文章列表')
@section('content')
    <ul class="nav nav-tabs articles-nav">
        <li role="presentation" class="active"><a href="#">最新</a></li>
        <li role="presentation"><a href="#">最热</a></li>
    </ul>
    @include('common._articles_summary', compact('articles'))
@endsection