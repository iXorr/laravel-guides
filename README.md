# Тема 5 - Представления и контроллеры

Мы продолжаем разрабатывать сайт по заданию из ``TASK.md``.

## Практическая часть

1. Создайте шаблон для всех страниц: **layout**.
2. Добавьте отображение ошибок.
3. Добавьте флеш-сообщения (после авторизации, например).
4. Создать страницы с просмотром сущностей - ``Course``, ``Application``.

## Представления

Основное предназначение шаблонов (представлений, или же ``views``) - перемешивание статической HTML-разметки с динамическими данными. Происходит это засчёт функции ``view()``.

### Функция view()

Она берёт шаблоны из папки ``resources/views`` и рендерит их, возвращая статические HTML-страницы. 

Первым аргументом она принимает название шаблона (например, если шаблон находится в ``resources/views/login.blade.php``, то название - ``login``, без двойного расширения файла)

> Если шаблон находится во вложенной структуре - например, в ``resources/views/courses/index.blade.php``, то вложенность в названии обозначается точкой - ``courses.index``.

Вторым аргументом - ассоциативный массив с данными, которые можно будет использовать внутри шаблона.

> Динамические данные могут быть и служебными (например, флеш-сообщения). Они цепляются ДО вызова шаблона, но всё так же доступны в них (например, это случается при редиректах).

```php
// Контроллер

public function showLoginForm(Request $request)
{
    return view('login', [
        'message' => 'It is AUTH page'
    ]);
}
```

```html
<!-- resources/views/login.blade.php -->

<p>{{ $message }}</p> <!-- It is AUTH page -->
```

### Редиректы

Внутри контроллеров редиректы принято применять после того, как метод выполнил своё действие - функция ``redirect()`` - или не смог его выполнить из-за какой-то ошибки - функция ``back()``.

```php
public function toIndex()
{
    return redirect('/'); // в качестве аргумента можно указать просто ссылку
}

public function toLogin()
{
    return redirect()
        ->route('login'); // или название роута
}
```

> Для ``back()`` нет смысла прописывать ссылку или название роута.

Также, к любой функции редиректа можно добавить **дополнительные данные**.

### Флеш-сообщения

Chain-метод ``with()`` позволит сохранить данные, которые будут доступны в шаблоне через функцию ``session()``.

```php
// Контроллер

public function toIndex()
{
    return redirect('/')
        ->with('message', 'Howdy!');
}

public function index()
{
    return view('/');
}
```

```html
<!-- resources/views/index.blade.php -->

<p>{{ session('message') }}</p>
```

### Сохранение инпутов

Если на странице была форма, но пользователь вернулся к ней из-за ошибки, можно сохранить ранние значения из инпутов: они доступны через ``old(НАЗВАНИЕ_ИНПУТА)``.

```php
// Контроллер

public function toIndex()
{
    return back()
        ->withInput();
}
```

```html
<!-- Blade-шаблон -->

<form
    action="{{ route('login') }}"
    method="POST"
>
    @csrf

    <input type="text" name="login" value="{{ old('login') }}">
    <input type="password" name="password">

    <input type="submit">
</form>
```

### Отображение кастомных ошибок

```php
// Контроллер

public function toIndex()
{
    return back()
        ->withErrors([
            'login' => 'Wrong data'
        ]);
}
```

```html
<!-- Blade-шаблон -->

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

    <input type="text" name="login" value="{{ old('login') }}">
    <input type="password" name="password">

    <input type="submit">
</form>
```

### Использование PHP-кода внутри шаблонов

Директива ``@php`` позволяет внутри шаблона выполнять любой PHP-код.

И для остальных директив можно пользоваться стандартным синтаксисом PHP, как и **фасадами**, которые мы обычно подключаем в контроллерах.

Разница лишь в том, что для остальных директив (кроме ``@php``), сам PHP-код пишется строго внутри скобок вызова директивы.

## Основные директивы

Стоит упомянуть, что все директивы между собой могут **комбинироваться**.

### Условное отображение
```html
@if (!Auth::check())
    <p>Вы не зашли в систему!</p>
@endif

<!-- А также версия с else -->

@if (!Auth::check())
    <p>Вы не зашли в систему!</p>
@else
    <p>Вы зашли в систему!</p> 
@endif
```

### Директивы цикла

Предусмотрена поддержка ``@continue`` и ``@break``.

```html
@for ($i = 0; $i < 10; $i++)
    The current value is {{ $i }}
@endfor
```

```html
@foreach ($users as $user)
    @if ($user->type == 1)
        @continue
    @endif

    <li>{{ $user->name }}</li>

    @if ($user->number == 5)
        @break
    @endif
@endforeach
```

```html
@forelse ($users as $user)
    <li>{{ $user->name }}</li>
@empty
    <p>No users</p>
@endforelse
```

```html
@while (true)
    <p>I'm looping forever.</p>
@endwhile
```

### Директивы аутентификации

Здесь проверка на то, вошёл ли пользователь в систему вообще.

```html
@auth
    <!-- Пользователь аутентифицирован -->
@endauth

@guest
    <!-- Пользователь не аутентифицирован -->
@endguest
```

### Директива авторизации

А здесь - проверка на то, под какой **ролью** он зашёл.

```html
@can('admin')
    <!-- Пользователь - админ -->
@endcan
```

А проверяется его роль не в контроллере, а в специальном месте - **провайдере**.

```php
<?php

// app/Providers/AuthServiceProvider.php

namespace App\Providers;

use App\Models\User; // подключаем модель пользователя
use Illuminate\Support\Facades\Gate; // подключаем этот фасад

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        //
    ];

    public function boot(): void
    {
        // Пишем гейт - функцию, которая возвращает true или false и,
        // в зависимости от этого значения, позволит рендерить шаблон с
        // проверкой на этот гейт или нет.

        Gate::define('admin', fn (User $user) 
            => $user->role->title === 'admin');
    }
}
```

> Провайдеры - специальные классы, код которых выполняется ДО контроллеров.

Также, авторизация может быть прописана и в маршрутах:
```php
<?php

// routes/web.php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::middleware('can:admin')->get('/', function() {
    return 'hello!';
}); // если пользователь не админ, выбрасывается 403

Route::get('login', [AuthController::class, 'showLoginForm']);
Route::post('login', [AuthController::class, 'login'])->name('login');
```