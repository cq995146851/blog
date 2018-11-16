@extends('layouts.app')
@section('title', $user->name . '的个人中心')
@section('content')
    <div class="col-sm-12 text-center">
        @include('common._avatar', ['class' => 'bigger-avatar', 'user' => $user])
        <h2>{{$user->name}}</h2>
    </div>
    <div class="col-sm-12 text-center user-info">
        <a href="{{route('users.index')}}?user_id={{$user->id}}&type=followings">
            <strong>{{$user->followings_count}}</strong>关注
        </a>
        <a href="{{route('users.index')}}?user_id={{$user->id}}&type=followers">
            <strong>{{$user->followers_count}}</strong>粉丝
        </a>
        <a href="javascript:void(0)">
            <strong>{{$user->articles_count}}</strong>文章
        </a>
    </div>
    <div class="col-sm-12 text-center follow-btn">
        @if(Auth::id() && Auth::id() != $user->id)
            @include('common._follow_btn', compact('user'))
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
@section('my-js')
    <script>
      //点赞
      function zan(article_id, self) {
        let that = $(self)
        $.ajax({
          type: 'post',
          dataType: 'json',
          url: '{{route("articles.zan")}}',
          data: {article_id: article_id, _token: "{{csrf_token()}}"},
          beforeSend() {
            layer.load()
          },
          success(res) {
            layer.closeAll()
            if (res.errcode) {
              layer.msg(res.errmsg, {time: 2000, icon: 2})
              return false
            }
            let count = parseInt(that.find('i').html());
            count++
            that.find('i').html(count)
            layer.msg(res.msg, {time: 1500, icon:1})
          },
          error(res) {
            layer.closeAll()
            layer.msg('请求失败', {time: 2000, icon: 2})
          }
        })
      }

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