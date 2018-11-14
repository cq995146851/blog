@extends('layouts.app')
@section('title', $user->name . '的个人中心')
@section('content')
    {{$user->name}}
@endsection