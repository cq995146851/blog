<ul class="media-list">
    @foreach($articles as $article)
        <li class="media">
            <div class="media-left">
                <a href="{{route('users.show', $article->user->id)}}">
                    <img class="media-object big-avatar" src="{{$article->user->avatar}}" alt="{{$article->user->name}}">
                </a>
            </div>
            <div class="media-body">
                <div class="media-heading">
                    {{str_limit($article->title, 25, '...')}}
                </div>
                <div class="media">
                    <div class="media-body">
                        <a href="javascript:void(0)"><i class=" fa fa-thumbs-up">15</i></a>
                        <a href="javascript:void(0)"><i class=" fa fa-comment">15</i></a>
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
