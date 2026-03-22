@props(['applications'])

@extends('layout')
@section('content')

@if ($applications->isNotEmpty())
    @foreach ($applications as $application)
        <p>{{ $application->id }} | {{ $application->title }}</p>
    @endforeach
@else
    <p>Empty list</p>
@endif

@endsection
