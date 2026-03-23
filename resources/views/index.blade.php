@extends('layout')
@section('content')

@if ($errors->any())
    @php
        dump($errors->toArray());
    @endphp
@endif

<div>Welcome to Main page!</div>

@endsection
