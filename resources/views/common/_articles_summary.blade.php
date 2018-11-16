<ul class="media-list">
    @foreach($articles as $article)
        <li class="media">
            <div class="media-left">
                <a href="{{route('users.show', $article->user->id)}}">
                    @include('common._avatar', ['class' => 'media-object big-avatar', 'user' => $article->user])
                </a>
            </div>
            <div class="media-body">
                <div class="media-heading">
                    {{str_limit($article->title, 25, '...')}}
                </div>
                <div class="media">
                    <div class="media-body">
                        <a href="javascript:void(0)" onclick="zan({{$article->id}}, this)"><i class=" fa fa-thumbs-up">{{$article->zans_count}}</i></a>
                        <a href="javascript:void(0)"><i class=" fa fa-comment">{{$article->comments_count}}</i></a>
                        <a href="javascript:void(0)"><i class=" fa fa-clock-o">{{$article->created_at->diffForHumans()}}</i></a>
                        <a class="pull-right" href="{{route('articles.show', $article->id)}}">查看详情<i class="fa fa-angle-right"></i></a>
                    </div>
                </div>
            </div>
        </li>
    @endforeach
</ul>
<div class="text-center">
    {{ $articles->links() }}
</div>
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
</script>
