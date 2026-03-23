@extends('layout')
@section('content')

<h2 class="mb-4">Регистрация</h2>

<form
    action="{{ route('register') }}"
    method="POST"
>
    @csrf

    <div class="mb-3">
        <label class="form-label">Логин</label>
        <input type="text" class="form-control" name="login" value="{{ old('login') }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="text" class="form-control" name="email" value="{{ old('email') }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Имя</label>
        <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Фамилия</label>
        <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Отчество</label>
        <input type="text" class="form-control" name="middle_name" value="{{ old('middle_name') }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Телефон</label>
        <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Пароль</label>
        <input type="password" class="form-control" name="password">
    </div>

    <button type="submit" class="btn btn-primary">Отправить</button>
</form>

@endsection
