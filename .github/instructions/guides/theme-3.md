# Тема 3 - Модели

На данный момент у вас уже должны быть таблицы со связями.

По этой теме мы будем работать с папкой ``app\Models``.

Мы продолжаем разрабатывать сайт по заданию из ``TASK.md``.

## Практическая часть

1. Создайте модели для всех таблиц со связами.
2. Отобразите список пользователей (преобразуйте коллекцию в массив).
3. Отобразите имя админа (пользователя с логином ``Admin``), а также название его роли.

## Определение моделей

Модели (или модели Eloquent) - классовая обёртка для таблиц из БД.

Одна таблица - одна модель.

> Модели автоматически цепляются к таблицам из БД, но они должны быть названы так же, как сами таблицы, только в единственном числе и с большой буквы (например, таблица - ``posts``, модель - ``Post``).

> Если название у таблицы составное - например, ``user_roles`` - называйте модель по **PascalCase** - например, ``UserRole``.

Модель с пользователем также есть по умолчанию.

> Будьте аккуратнее с protected-полем **$casts**: оно отвечает за преобразование данных и в нём обычно прописано хэширование паролей. Советую просто удалить это поле.

В моделях важны следующие protected-поля:

- **$fillable**: массив с атрибутами, которые будут приниматься при создании или изменении записи в таблице. Будьте с ним особенно внимательны:
    - если в HTTP-запросе, например, вы передаёте ``first_name`` и ``last_name``, но в модели они не прописаны, возникнет или пустой SQL-запрос, или ошибка.
    - стандартные поля ``id``, ``created_at`` и ``updated_at`` не пишутся в **$fillable**, т.к. в БД они заполняются автоматически.
- **$table**: название таблицы; используем это поле, только если слово на латинице сложно склоняется (``user -> users`` легко склоняется, ``person -> people`` или ``history -> histories`` - нет)
- **$timestamps**: флаг, который показывает, есть ли в нашей таблицы метки времени создания и изменения записи. По умолчанию стоит **true**, но если вы не пользовались миграциями - поставьте **false**, иначе будет ошибка с SQL-запросом.

## Создание модели

```bash
php artisan make:model Course
```

> Для пользователей всегда используйте заготовленную модель. У неё расширенный функционал (авторизация), нежели чем у обычной модели, засчёт класса ``Authenticatable``.

## Типы возвращаемых значений при работе с моделями

Методы Eloquent возвращают один из двух типов:

| Что возвращает | Пример | Что это | Когда использовать |
|---------------|--------|---------|-------------------|
| **Данные** (готовая коллекция или модель) | `User::all()`, `$user->role` | `Collection` или `User` | Когда нужно работать с результатами: выводить в шаблоне, перебирать, читать поля |
| **Запрос** (ещё не выполнен) | `User::where(...)`, `$user->role()` | `QueryBuilder` или `UserRole` | Когда нужно уточнить запрос: добавить условия, сортировку, связи |

```php
// Данные — можно сразу использовать
$users = User::all();                     // Collection или [] 
$user = User::find(1);                    // User или NULL
$role = $user->role;                      // User или NULL

// Запрос — нужно выполнить
$query = User::where('login', 'Admin');   // Query Builder
$relation = $user->role();                // Relation object
```

**Collection** - это объект-обёртка над массивом данных. Он позволяет:
```php
$users = User::all();

// Обращаться как к объекту (вместо $users[0]['name'])
$users->first()->name;

// Удобные методы
$users->where('login', 'admin');   // фильтрация
$users->pluck('email');            // получить список по полю
$users->count();                   // количество
$users->isNotEmpty();              // проверить, пустой ли список
```

Если нужно быстро отобразить коллекцию (проверить, что приходят нужные данные), используйте метод **toArray()**:

```php
dump($user); // вам отобразится объект с огромным количеством
             // служебных свойств и методов, которые вам не нужны

dump($user->toArray()); // ['login' => 'test', 'password' => 'qwe123']
```

Если вы попытаетесь внедрить коллекцию в blade-шаблон - всё будет ок:
```php
// resources/views/example.blade.php

@php
    $userRole = $user->role;
@endphp

<div class="card">
    <p>ID: {{ $userRole->id }}</p>
    <p>Название: {{ $userRole->title }}</p>
</div>
```

Но если вам вернётся запрос, та же запись в шаблоне вызовет ошибку.

Запрос, ожидающий своё выполнение, можно дописать (добавив условия):

```php
dump($user->role()->where('title', 'admin'));
dump(User::where('first_name', 'John')->where('last_name', 'Doe'));
```

Но для того, чтобы выполнить его и преобразовать в Collection - вызовите методы **get()** или **first()**:
```php
dump($user->role()->get());
dump(User::where('first_name', 'John')->first());
```

## Обращение к модели

Вам нужно вернуть список пользователей:
```php
<?php

// app/Http/Controllers/DBCheckController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User; // подключаете модель

class DBCheckController extends Controller
{
    public function index(Request $request)
    {
        dd(User::all()); // обращаетесь к ней
    }
}
```

Вы обращаетесь к классу **User**, а через него - к методу **all()** - и он возвращает вам коллекцию пользователей.

Методы, возвращающие данные (коллекцию):
- all()
- find(**$id**)
- findOrFail(**$id**) - если записи нет, выбрасывается ``404``

Методы, НЕ возвращающие данные:
- where(**$field**, **$value**)
- role() - или любой метод связи
- create(**$data**)
- update(**$data**)
- delete()

Последние три играют особую роль в контроллерах и, по сути, представляют собой реализацию CRUD-операций.

## Создание связи

### О связях в Laravel

Cвязи имеют разновидности - ``1:1``, ``1:M``:
1. hasOne(**класс**, **внешнний ключ**, **локальный ключ**).
2. hasMany(**класс**, **внешнний ключ**, **локальный ключ**).

**Внешний ключ** - первичный ключ ДРУГОЙ модели, на которую мы ссылаемся.

**Локальный ключ** - вторичный ключ ВНУТРИ ТЕКУЩЕЙ модели. 

> В рамках дем. экзамена связь ``M:M`` НЕ ИСПОЛЬЗУЕТСЯ, хоть методы для неё тоже есть.

> Также есть обратные связи: методы, начинающиеся не с **has**, а с **belongsTo**. Разницу между ними опустим; **has**-методы проще применять.

### Пример связи ``1:1``

У нас есть две таблицы: **users** с вторичным ключом ``user_role_id`` и **user_roles**. Для обеих есть и соответствующие модели.

Чтобы через пользователя обращаться к его роли, нам нужно написать метод **role()**.
```php
<?php

// app/Models/User.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'user_role_id',
        'login',
        // прочие поля пользователя
    ];

    public function role()
    {
        return $this->hasOne(UserRole::class, 'id', 'user_role_id');
    }
}
```

Один вторичный ключ = одна связь.

> Частая ошибка: связь есть, а данных по ней - нет (возвращается ``null``, хоть данные в БД точно есть). Для решения попробуйте поменяйте внешний и локальный ключи местами.

```php
public function role()
{
    return $this->hasOne(UserRole::class, 'user_role_id', 'id'); // null
}

public function role()
{
    return $this->hasOne(UserRole::class, 'id', 'user_role_id'); // UserRole
}
```

Применение связи в модели может выглядеть так:
```php
<?php

// app/Http/Controllers/DBCheckController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class DBCheckController extends Controller
{
    public function index(Request $request)
    {
        $user = User::find(1);   // берём пользователя с ID = 1
        
        dump($user->first_name); // отображаем его имя
        dd($user->role->title);  // отображаем название СВЯЗАННОЙ роли
    }
}
```

> Обращайтесь к ``role`` как к свойству классу для получения данных.

### Пример связи ``1:M``

```php
<?php

// app/Models/UserRole.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'user_role_id', 'id');
    }
}
```

```php
<?php

// app/Http/Controllers/DBCheckController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\UserRole; // подключайте модель вручную

class DBCheckController extends Controller
{
    public function index(Request $request)
    {
        $adminRole = UserRole::where('title', 'admin')->firstOrFail();
        dump($adminRole->users);
    }
}
```