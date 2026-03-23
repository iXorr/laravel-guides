@props(['applications'])

@extends('layout')
@section('content')

@if ($applications->isNotEmpty())
    @foreach ($applications as $application)
        <p>{{ $application->id }} | {{ $application->title }}</p>
    @endforeach
@else
    <div>Empty list</div>
@endif

@endsection
