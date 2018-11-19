@extends('layouts.app')
@section('title', '帖子详情')
@section('content')
    <div class="col-sm-12 margin-ten">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="{{route('articles.by_topic', $article->topic->id)}}">
                    <span class="panel-title">{{$article->topic->name}}专题</span>
                </a>
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
                <h5 class="text-center"><strong>
                        {{$article->user->name}}</strong>发布于<strong>{{($article->updated_at ? $article->updated_at : $article->created_at)->diffForHumans()}}</strong>
                </h5>
                {!! $article->content !!}
            </div>
        </div>
    </div>
    @if(Auth::check())
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">发表评论</h3>
                </div>
                <div class="panel-body">
                    @include('common._error')
                    <form action="{{route('comments.store')}}" method="post" role="form">
                        {{csrf_field()}}
                        <div class="form-group">
                            <textarea name="content" class="form-control" rows="3" placeholder="说点什么吧..."></textarea>
                        </div>
                        <input type="hidden" name="article_id" value="{{$article->id}}">
                        @include('common._submit_btn', ['content' => '发表'])
                    </form>
                </div>
            </div>
        </div>
    @else
        @include('common._no_login', ['content' => '您尚未登录，登录后可以参与评论'])
    @endif
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">全部评论</h3>
            </div>
            <div class="panel-body">
                @if($comments->isNotEmpty())
                    @foreach($comments as $comment)
                        <ul class="media-list">
                            <li class="media">
                                <div class="media-left">
                                    <a href="{{route('users.show', $comment->user->id)}}">
                                        @include('common._avatar', ['class' => 'media-object avatar', 'user' => $comment->user])
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h5 class="media-heading">
                                        <strong>{{$comment->user->name}}</strong>
                                        <strong>{{$comment->created_at->diffForHumans()}}</strong>
                                        @if(!$comment->is_new)
                                            <span class="comment-plus">追加</span>
                                        @endif
                                        @if(Auth::id() == $comment->user->id)
                                            <span class="pull-right" onclick="delete_comment()" style="cursor: pointer"><i
                                                        class="fa fa-trash"></i></span>
                                            <form action="{{route('comments.destroy', $comment->id)}}" method="post"
                                                  id="myCommentForm" hidden>
                                                {{csrf_field()}}
                                                {{method_field('DELETE')}}
                                            </form>
                                        @endif
                                    </h5>
                                    <div>
                                        {{$comment->content}}&nbsp;&nbsp;&nbsp;&nbsp;
                                        @include('common._zan', ['data' => $comment, 'url' => route("comments.zan")])
                                    </div>
                                </div>
                            </li>
                        </ul>
                    @endforeach
                    {{ $comments->links()  }}
                @else
                    @include('common._no_content', ['content' => '还没有任何评论，快来抢沙发吧'])
                @endif
            </div>
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

      function delete_comment() {
        layer.confirm('确定要删除这条评论?',
            {
              btn: ['删了', '再想想'],
              title: '警告'
            }, function () {
              $("#myCommentForm").submit();
            })
      }
    </script>
@endsection