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
                        @include('common._zan', ['data' => $article, 'url' => route("articles.zan")])
                        <a href="{{route('articles.show', $article->id)}}"><i class=" fa fa-comment">{{$article->comments_count}}</i></a>
                        <a href="javascript:void(0)"><i class=" fa fa-clock-o">{{($article->updated_at ? $article->updated_at : $article->created_at)->diffForHumans()}}</i></a>
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

