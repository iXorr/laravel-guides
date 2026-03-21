# Тема 4 - Маршруты и контроллеры

Мы продолжаем разрабатывать сайт по заданию из ``TASK.md``.

## Практическая часть

1. Создайте ``AuthController`` с методами ``showLoginForm`` - для отображения страницы авторизации (с формой) и ``login`` - для обработки данных из формы.
2. Создайте ``CourseController`` с методом ``index`` - для просмотра курсов.
3. Создайте страницы: ``авторизация``, ``регистрация``, ``главная`` (пусть будет отображаться список курсов).

## Маршруты

Перед тем, как запрос обрабатывается контроллером, он попадает в маршрутизатор.

У запроса может быть любой HTTP-метод: ``GET``, ``POST``, ``PATCH``, ``PUT``, ``DELETE``. И даже если мы просто запрашиваем главную страницу, мы тоже отправляем запрос (а именно, GET-запрос).

```php
<?php

// routes/web.php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;

Route::get('/', [CourseController::class, 'index']); // главная страница

Route::get('login', [AuthController::class, 'showLoginForm']); // страница /login
Route::post('login', [AuthController::class, 'login']); // страница /login
```

За приём запроса отвечает фасад **Route**. У него есть статические методы, названные как HTTP-методы; первым аргументом они принимают **эндпойнт** (часть строки, которую сервер отлавливает) с соответствующим HTTP-методом, а вторым аргументом - **действия с запросом**, который удалось отловить.

Действия с запросом могут представлять собой:
1. Массив, где первый элемент - класс контроллера, второй - метод внутри него.
2. Анонимную функцию: в PHP её принято называть **замыканием**.

```php
Route::get('/', function() {
    return 'test message';
});
```

### Именование роута

Каждый **роут** (маршрут) может также иметь имя. Через **method chaining** добавляем ``name``.
```php
Route::get('login', [AuthController::class, 'showLoginForm'])->name('showLoginForm');
Route::post('login', [AuthController::class, 'login'])->name('login');
```

И это имя можно использовать, например, в шаблоне навигационной панеле:
```html
<form
    method="POST"
    action="{{ route('login') }}"
>
    // форма авторизации
</form>
```

Функция ``route`` принимает название роута и возвращает ссылку на него: в примере выше эта ссылка - ``http://localhost/login``.

### Извлечение данных из роута

В приложении на чистом PHP для передачи ID сущности, мы использовали GET-параметр: ``http://localhost/courses?id=1`` - например, мы запрашиваем информацию о каком-то конкретном курсе.

В роуте это можно сделать таким образом:
```php
Route::get('courses/{id}', [CourseController::class, 'show']);
```

В метод **show** контроллера **CourseController** попадёт динамическое значение ``id``:
- Если ссылка: ``http://localhost/courses/1``, то ``id`` = 1.
- Если ссылка: ``http://localhost/courses/5``, то ``id`` = 5.
- Если ссылка: ``http://localhost/courses/10``, то ``id`` = 10.

## Контроллеры

У нас есть два маршрута для авторизации:
1. ``GET /login`` - выдаём страницу авторизации (с формой)
2. ``POST /login`` - приём данных из формы и их обработка.

Сперва создадим контроллер через artisan:
```bash
php artisan make:controller AuthController
```

Название контроллера строится по следующим правилам:
1. Записывается в PascalCase.
2. На конце есть слово - **Controller**.
3. Если контроллер связан с сущностью, сама сущность - в единственном числе: например, ``CourseController`` или ``UserController``.

Далее, уже перейдя в контроллер, мы пишем публичные методы (которые вызываются маршрутизатором).

```php
<?php

// app/Http/Controllers/AuthController

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm(Request $request)
    {
        return view('login'); // возвращаем страницу по адресу
                              // resources/views/login.blade.php
    }

    public function login(Request $request)
    {
        //
    }
}
```

Имейте в виду, что каждый публичный метод, который вызывается маршрутизатором, по умолчанию принимает объект типа **Request** (даже если вы не указали его в аргументах метода).

```php
public function showLoginForm(Request $request)
{
    dump($request->all());       // Все параметры и инпуты из запроса

    dump($request->get('page')); // GET-параметр PAGE
                                 // http://localhost/login?page=1
}

public function login(Request $request)
{
    dump($request->input('email'));    // Данные из <input name="email">
    dump($request->input('password')); // Данные из <input name="password">

    dump($request->email);             // Аналогичное обращение к
    dump($request->password);          // данным из формы
}
```

### Получение динамического значения из роута

Динамические значения записываются и принимаются ПОСЛЕ аргумента **$request**.

```php
<?php

// app/Http/Controllers/CourseController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function show(Request $request, int $id)
    {
        return "Вы запросили: $id";
    }
}
```

### Валидация

Вот ваша страница авторизации с формой:
```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
</head>
<body>
    <form
        action="{{ route('login') }}"
        method="POST"
    >
        @csrf

        <input type="text" name="login">
        <input type="password" name="password">

        <button type="submit">Отправить</button>
    </form>
</body>
</html>
```

> ``@csrf`` - важный макрос в Blade-шаблонизаторе, который вместе с данными формы отправляет csrf-токен, без которого сервер будет отбрасывать ошибку 419.

Вы отправили логин и пароль. Но эти данные могут быть неправильными или вовсе пустыми. Эту проблему решает метод ``validate`` для объекта типа **Request**.

```php
<?php

// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm(Request $request)
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'login' => [
                'required'
            ],

            'password' => [
                'required'
            ]
        ]);

        dd($data);
    }
}
```

Метод ``validate`` принимает ассоциативный массив, где название элемента - поле (инпут) POST-запроса, а содержимое элемента - правила.

### Основные правила валидации

- ``required``: обязательное поле.
- ``nullable``: необязательное поле.
- ``string``: строковое значение.
- ``email``: формат почты - example@example.
- ``integer``: целочисленное значение.
- ``decimal:ДРОБНАЯ_ЧАСТЬ``: дробное число.
- ``min:ЧИСЛО``: минимальное кол-во символов ИЛИ минимальное число.
- ``max:ЧИСЛО``: максимальное кол-во символов ИЛИ максимальное число.
- ``regex:/ВЫРАЖЕНИЕ/``: регулярное выражение.
- ``unique:ТАБЛИЦА,ПОЛЕ``: проверка на уникальность по полю в БД.
- ``exists:ТАБЛИЦА,ПОЛЕ``: проверка на наличие записи по полю в БД.

Пример правил:
```php
'password' => [
    'required',
    'min:8',
    'regex:/[A-Z]/',  // заглавная буква
    'regex:/[a-z]/',  // строчная буква
    'regex:/[0-9]/',  // цифра
    'regex:/[\W_]/',  // спецсимвол
],

'login' => [
    'required',
    'min:6',
    'max:20',
    'regex:/^[a-zA-Z0-9]+$/',   // только латинские буквы и числа
    'unique:users,login'        // чтобы не было одинаковых логинов
],

'full_name' => [
    'required',
    'min:2',
    'max:100',
    'regex:/^[а-яА-ЯёЁ\s\-]+$/u', // только кириллица, пробелы и тире
],

'phone' => [
    'required',
    'regex:/^8\(\d{3}\)\d{3}-\d{2}-\d{2}$/', // формат 8(XXX)XXX-XX-XX
    'unique:users,phone'
],

'email' => [
    'required',
    'email',
],
```

### Провал валидации

Если данные НЕ прошли валидацию, то контроллер возвращает редирект на ту же страницу вместе с ошибкой.
```php
    public function login(Request $request)
    {
        $data = $request->validate([
            'login' => [
                'required'
            ],

            'password' => [
                'required'
            ]
        ]);

        // Представим, что данные НЕ прошли

        return back()
            ->withErrors([
                'login' => 'ERROR MESSAGE',
                'password' => 'ERROR MESSAGE'
            ]);
    }
```

И мы увидим эти ошибки, если добавим условие для их отображения.
```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
</head>
<body>
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
</body>
</html>
```
