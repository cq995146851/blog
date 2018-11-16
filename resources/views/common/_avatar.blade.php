@if($user->avatar)
    <img class="{{$class}}" src="{{$user->avatar}}" alt="{{$user->name}}">
@else
    <img class="{{$class}}" src="{{asset('/images/noimg.jpg')}}" alt="{{$user->name}}">
@endif