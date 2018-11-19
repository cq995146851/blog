@extends('layouts.app')
@section('title', $user->name . '的个人中心')
@section('content')
    <div class="col-sm-12 text-center">
        @include('common._avatar', ['class' => 'bigger-avatar', 'user' => $user])
        <h2>{{$user->name}}</h2>
    </div>
    <div class="col-sm-12 text-center user-info">
        @if($user->followings_count)
            <a href="{{route('users.index')}}?user_id={{$user->id}}&type=followings">
        @else
            <a href="javascript:void(0)">
        @endif
            <strong>{{$user->followings_count}}</strong>关注
        </a>
        @if($user->followers_count)
            <a href="{{route('users.index')}}?user_id={{$user->id}}&type=followers">
        @else
            <a href="javascript:void(0)">
        @endif
            <strong>{{$user->followers_count}}</strong>粉丝
        </a>
        <a href="javascript:void(0)">
            <strong>{{$user->articles_count}}</strong>文章
        </a>
    </div>
    <div class="col-sm-12 text-center follow-btn">
        @if(!Auth::id())
            @include('common._no_login', ['content' => '您尚未登录，登录后才可以关注用户'])
        @elseif(Auth::id() != $user->id)
            @if(Auth::user()->isFollowing($user->id))
                <button class="btn btn-danger" status="0">
                    取消关注
                </button>
            @else
                <button class="btn btn-primary" status="1">
                    关注
                </button>
            @endif
        @endif
    </div>
    <div class="col-sm-12">
        @if($articles->isNotEmpty())
            @include('common._articles_summary', compact('articles'))
        @else
            @include('common._no_content', ['content' => '暂没有发布帖子哦'])
            @if($user->id == Auth::id())
            <div class="text-center">
                <a href="{{route('articles.create')}}" class="btn btn-primary">去发布</a>
            </div>
            @endif
        @endif
    </div>
@endsection
@section('my-js')
    <script>
      $(function () {
        //关注
        $('.follow-btn button').click(function () {
          let status = $(this).attr('status'),
              user_id = "{{$user->id}}"
          $.ajax({
            type: 'post',
            dataType: 'json',
            url: '{{route("users.follow")}}',
            data: {user_id: user_id, status: status, _token: "{{csrf_token()}}"},
            beforeSend() {
              layer.load(3)
            },
            success(res) {
              layer.closeAll()
              if (res.errcode == 1) {
                layer.msg(res.errmsg, {time: 200, icon: 2})
                setTimeout(() => {
                  location.href = "{{route('sessions.create')}}"
                }, 2000)
                return false;
              }
              layer.msg(res.msg, {time: 2000, icon: 1})
              setTimeout(() => {
                location.reload()
              }, 2000)
            },
            error(res) {
              layer.closeAll()
              if (res.responseJSON.errors) {
                let errors = res.responseJSON.errors,
                    error_str = ''
                for (let index in errors) {
                  $(errors[index]).each(function (k, v) {
                    error_str += v + '<br/>'
                  })
                }
                layer.alert(error_str, {title: '参数错误', icon: 2})
              }
              console.log(res)
            }
          })
        })
      })
    </script>
@endsection