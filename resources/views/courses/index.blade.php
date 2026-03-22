@props(['courses'])

@extends('layout')
@section('content')

@if ($courses->isNotEmpty())
    @foreach ($courses as $course)
        <p>{{ $course->id }} | {{ $course->title }}</p>
    @endforeach
@else
    <p>Empty list</p>
@endif

@endsection
