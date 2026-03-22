@extends('layout')
@section('content')

@if ($errors->any())
    @php
        dump($errors->toArray());
    @endphp
@endif

<p>Welcome to Main page!</p>

@endsection
