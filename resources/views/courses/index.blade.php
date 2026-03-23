@props(['courses'])

@extends('layout')
@section('content')

<h2 class="mb-4">Курсы</h2>

<a
    href="{{ route('courses.create') }}"
    class="btn btn-primary mb-4"
>
    Записаться на новый курс
</a>

@if ($courses->isNotEmpty())
    @foreach ($courses as $course)
        <p>{{ $course->id }} | {{ $course->title }}</p>
    @endforeach
@else
    <div>Empty list</div>
@endif

@endsection
