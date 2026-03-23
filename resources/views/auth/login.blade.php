@extends('layout')
@section('content')

<h2 class="mb-4">Авторизация</h2>

<form
    action="{{ route('login') }}"
    method="POST"
>
    @csrf
    <div class="mb-3">
        <label class="form-label">Логин</label>
        <input type="text" class="form-control" name="login">
    </div>

    <div class="mb-3">
        <label class="form-label">Пароль</label>
        <input type="password" class="form-control" name="password">
    </div>

    <button type="submit" class="btn btn-primary">Отправить</button>
</form>

@endsection
