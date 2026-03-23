# Тема 6 - CRUD-операции

Эта тема - завершающая. На ней сайт по заданию из ``TASK.md`` будет полностью выполнен.

**CRUD-операции** - это набор операций, которые можно совершать над сущностями: CREATE - создание, READ - чтение, UPDATE - обновление, DELETE - удаление.

## Практическая часть

1. Создайте resource-контроллеры для сущностей ``Course`` и ``Application``.
2. Написать полный функционал для этих сущностей - CRUD.
3. При написании компонентов используйте Bootstrap (по **Zeal**).

## Resource-контроллер

До этого мы создавали пустые контроллеры, где сами писали методы (в основном, ``index``). Но в Laravel предусмотрены **пресеты** для контроллеров, и один из них - ``--resource``.

```php
php artisan make:controller CourseController --resource
```

Это - такой контроллер, внутри которого уже есть методы:
- ``index()``: возвращает компонент с полным списком сущностей.
- ``create()``: возвращает форму для создания сущности.
- ``store(Request $request)``: принимает POST-данные и сохраняет новую сущность.
- ``show(string $id)``: возвращает компонент ЕДИНИЧНОЙ сущности.
- ``edit(string $id)``: возвращает форму для редактирования сущности.
- ``update(Request $request, string $id)``: принимает PUT/PATCH-данные и изменяет сущность.
- ``destroy(string $id)``: принимает DELETE-запрос и удаляет сущность.

### Route::resource()

Для resource-контроллера не нужно писать каждый отдельный маршрут.

```php
// routes/web.php

Route::resource('courses', CourseController::class);
```

Эта запись разворачивается в следующий набор маршрутов:
```
+-----------+-------------------------+------------------+---------+
| Метод     | URI                     | Имя роута        | Метод   |
+-----------+-------------------------+------------------+---------+
| GET|HEAD  | /                       |                  | Closure |
| GET|HEAD  | courses                 | courses.index    | index   |
| POST      | courses                 | courses.store    | store   |
| GET|HEAD  | courses/create          | courses.create   | create  |
| GET|HEAD  | courses/{course}        | courses.show     | show    |
| PUT|PATCH | courses/{course}        | courses.update   | update  |
| DELETE    | courses/{course}        | courses.destroy  | destroy |
| GET|HEAD  | courses/{course}/edit   | courses.edit     | edit    |
+-----------+-------------------------+------------------+---------+
```

### Порядок роутов

Обратите внимание на этот порядок роутов:
1. ``courses/create``.
2. ``courses/{course}``.

Create-роут должен находиться выше. Если поменять их местами, create-роут никогда не будет достигнут, т.к. маршрутизатор будет перехватывать ``courses/{course}``. 
1. ``courses/{course}``; технически, URI ``courses/create`` подходит под этот паттерн, т.к. часть **course** может быть **любой строкой**.
2. ``courses/create``.

> Если ваше приложение будет возвращать не ту страницу (по заданному вами URI) или ошибку 404, **меняйте роуты местами**.

### Замена $id на модель

Поскольку не важно, как мы называем динамические параметры из роута (которые оборачиваем в ``{}``), в контроллере можно менять не только их название, но и тип данных.

Например, мы меняем метод ``show()``:
```php
// app/Http/Controllers/CourseController.php

class CourseController extends Controller {
    //
    
    public function show(string $id)
    {
        //
    }
}
```

На этот вариант:
```php
// app/Http/Controllers/CourseController.php

use App\Models\Course;

class CourseController extends Controller {
    //
    
    public function show(Course $course)
    {
        return view('courses.show', [
            'course' => $course
        ]);
    }
}
```

И теперь, **$course** - это полноценная модель.

Если в методе контроллера для принимающего аргумента из роута вы указываете тип модели, то значение аргумента берётся как **ID** и вставляется в метод ``::find($id)``. Таким образом возвращается либо модель с соответвующим ID, либо NULL.

## Реализация CRUD в контроллерах

Напомню, что метод ``validate()`` возвращает только те поля, которые проходят валидацию, и только в виде ассоциативного массива: ``[НАЗВАНИЕ_ПОЛЯ => ЗНАЧЕНИЕ_ПОЛЯ]``.

CRUD-методы - ``create`` и ``update`` - как раз тоже принимают в качестве аргумента такие же ассоциативные массивы.

### Создание

```php
// app/Http/Controllers/CourseController.php

public function store(Request $request)
{
    $data = $request->validate([
        'title' => ['required'],
        'wanted_start_date' => ['required'],
        'payment_method' => ['required'],
    ]);

    $course = Course::create($data);

    return redirect()
        ->route('courses.index')
        ->with('message', 'Course created!');
}
```

### Редактирование

```php
// app/Http/Controllers/CourseController.php

public function update(Request $request, Course $course)
{
    $data = $request->validate([
        'title' => ['required'],
        'wanted_start_date' => ['required'],
        'payment_method' => ['required'],
    ]);

    $course->update($data); // отличие только в одной строке

    return redirect()
        ->route('courses.index')
        ->with('message', 'Course updated!');
}
```

Но следует учесть, что этот метод принимает только PUT/PATCH-методы.

Значит, в форме, из которой данные будут отправляться, нужно переопределять метод.

```html
<!-- resources/views/courses/edit.blade.php -->

@props(['course'])

@extends('layout')
@section('content')

<form
    action="{{ route('courses.update', $course->id) }}"
    method="POST"
>
    @csrf
    @method('put')

    <!-- Остальная форма -->
</form>

@endsection
```