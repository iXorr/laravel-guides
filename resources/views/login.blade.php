@extends('layout')
@section('content')

@if ($errors->any())
    @php
        dump($errors->toArray());
    @endphp
@endif

<form
    action="{{ route('login') }}"
    method="POST"
>
    @csrf

    <input type="text" name="login">
    <input type="password" name="password">

    <input type="submit">
</form>

@endsection
