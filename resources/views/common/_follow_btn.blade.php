@if(Auth::user()->isFollowing($user->id))
    <button class="btn btn-danger" status="0">
        取消关注
    </button>
@else
    <button class="btn btn-primary" status="1">
        关注
    </button>
@endif
