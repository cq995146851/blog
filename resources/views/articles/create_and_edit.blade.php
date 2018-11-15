@extends('layouts.app')
@section('title', '新建文章')
@section('styles')
    <link rel="stylesheet" href="{{asset('css/lib/simditor/simditor.css')}}">
@endsection
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                @if($article->id)
                    <i class="fa fa-edit">编辑帖子</i>
                @else
                    <i class="fa fa-pencil-square-o">新建帖子</i>
                @endif
            </h3>
        </div>
        <div class="panel-body">
            @include('common._error')
            @if($article->id)
                <form action="{{route('articles.update', $article->id)}}" method="post" role="form">
                {{method_field('PUT')}}
            @else
                <form action="{{route('articles.store')}}" method="post" role="form">
            @endif
                {{csrf_field()}}
                <div class="form-group">
                    <select class="form-control" name="topic_id">
                        <option value="" selected disabled hidden>请选择专题</option>
                        @foreach($topics as $topic)
                            <option value="{{$topic->id}}" @if($article->topic_id == $topic->id) selected @endif>
                                {{$topic->name}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" name="title" value="{{old('title', $article->title)}}" class="form-control" placeholder="请输入标题">
                </div>
                <div class="form-group">
                    <textarea id="editor" name="content" placeholder="内容至少10个字符">
                        {{old('title', $article->content)}}
                    </textarea>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        @include('common._submit_btn', ['content'=> '保存'])
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('my-js')
    <script src="{{asset('/js/lib/simditor/module.js')}}"></script>
    <script src="{{asset('/js/lib/simditor/hotkeys.js')}}"></script>
    <script src="{{asset('/js/lib/simditor/uploader.js')}}"></script>
    <script src="{{asset('/js/lib/simditor/simditor.js')}}"></script>
    <script>
     $(function () {
       var editor = new Simditor({
         textarea: $('#editor'),
         upload: {
           url: '{{ route('articles.upload_img') }}',
           params: { _token: '{{ csrf_token() }}' },
           fileKey: 'upload_file',
           connectionCount: 3,
           leaveConfirm: '文件上传中，关闭此页面将取消上传。'
         },
         pasteImage: true,
       });
     })
    </script>
@endsection