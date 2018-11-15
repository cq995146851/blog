@extends('layouts.app')
@section('title', '帖子详情')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="panel-title">帖子详情</span>
            @can('delete', $article->user)
                <a href="javascript:void(0)" onclick="delete_article()"><i class="fa fa-trash pull-right">删除</i></a>
                <form action="{{route('articles.destroy', $article->id)}}" method="post" id="myForm" hidden>
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                </form>
            @endcan
            @can('update', $article->user)
                <a href="{{route('articles.edit', $article->id)}}"><i class="fa fa-edit pull-right">修改</i></a>
            @endcan
        </div>
        <div class="panel-body">
            <h2 class="text-center">{{$article->title}}</h2>
            {!! $article->content !!}
        </div>
    </div>
@endsection
@section('my-js')
    <script>
      function delete_article() {
        layer.confirm('确定要删除这条帖子?',
            {
              btn: ['删了', '再想想'],
              title: '警告'
            }, function () {
              $("#myForm").submit();
            })
      }
    </script>
@endsection