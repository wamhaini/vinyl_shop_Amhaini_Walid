@extends('layouts.template')

@section('title', 'Welcome to The Vinyl Shop')

@section('main')
<h1>The Vinyl Shop</h1>

<p>Welcome to the website of The Vinyl Shop, a large online store with lots of (classic) vinyl records.</p>

{{--<ul>--}}
{{--    @foreach($users as $user)--}}
{{--        <li>{{ $user->name }} : <a href="{{ $user->email }}">{{ $user->email }}</a></li>--}}
{{--    @endforeach--}}
{{--</ul>--}}
@endsection
