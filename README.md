# Тема 2 - Проектирование БД

Создавать и наполнять таблицы можно не только через phpMyAdmin. 

Есть подход **code-first**. Это означает, что все сущности и связи между ними мы описываем при помощи PHP-кода.

По этой теме мы будем работать с папкой ``database``.

Также, с этой темы мы разрабатываем сайт по заданию из ``TASK.md``.

> Если же вас полностью устраивает phpMyAdmin, можете пропустить теорию и переходить сразу к практической части.

## Практическая часть

Создайте таблицы ``user_roles``, ``users``, ``courses``, ``application_statuses`` (статусы заявок), ``applications`` (заявки). Добавьте пользователя-админа.

## Валидация данных

Если в задании описывают сущность, то могут быть упоминания, вроде «не менее 6 символов», «кириллица и пробелы», «формат: 8(XXX)XXX-XX-XX» и прочее.

Проверка данных (валидация) будет происходить в другом месте - в **контроллерах**.

## Миграции

Миграции - файлы, которые описывают действия с таблицами БД (в нашем случае - создание и удаление). Там же описываются их атрибуты (столбцы).

Миграция с таблицей пользователей имеется по умолчанию. По её примеру видно, что для создания атрибута мы обращаемся к **$table**, вызываем метод (по названию типа данных) и пишем в аргумент название колонки.

Также, при создании атрибута можно накладывать ограничения: например, ``уникальность``, ``значение по умолчанию`` или ``хранение NULL``.

### Пример колонок с другими типами данных
```php
public function up(): void
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();

        $table->string('name'); // до 255 символов
        $table->text('description'); // до 65535 символов
        $table->integer('age');
        $table->string('email')->unique(); // с ограничением уникальности
        $table->string('note')->nullable(); // может хранить значение NULL
        $table->boolean('is_admin')->default(true); // со значением по умолчанию
        $table->enum('status', ['new', 'accepted'])->default('new');
        $table->timestamp('start_date'); // колонка с желаемой датой начала

        $table->timestamps(); // два поля - created_at, updated_at
    });
}
```

> Enum'ы - удобная штука для выбора роли пользователя или статуса заказа. Но она нарушает 3НФ. Просто имейте в виду.

Методы ``id`` и ``timestamps`` появляются по умолчанию при создании новых миграций.

### Пример связи
```php
$table->foreignId('user_role_id') // вторичный ключ
    ->constrained('user_roles');  // таблица, куда мы ссылаемся
```

> Если название - составное, используйте **snake_case**.

### Создание новой миграции

Придерживайтесь следующего формата названий: **create_ТАБЛИЦА_table**.

```bash
php artisan make:migration create_applications_table
```

Обратите внимание, что некоторые миграции должны быть запущены раньше других (например, таблица ``user_roles`` должна создастся раньше, чем ``users``, в которой есть вторичный ключ ``user_role_id``).

Для того, чтобы одна миграция запустилась раньше другой, просто **поменяйте дату в имени файла**: (например, ``2026_03_20_085448_create_user_roles_table.php`` -> ``2013_03_20_085448_create_user_roles_table.php``).

### Применение миграций

```bash
php artisan migrate # создание
php artisan migrate:reset # откат
php artisan migrate:refresh # пересоздание
php artisan migrate --seed # создание, затем - заполнение
php artisan migrate:refresh --seed # пересоздание, затем - заполнение
```

## Сидеры

Сидеры - файлы для наполнения таблиц тестовыми данными.

> Но нам потребуется только **DatabaseSeeder** - главный файл-сидер.

Используя тот же фасад **DB**, добавляем роли и админа (логин и пароль - по ТЗ).

```php
<?php

// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('user_roles')->insert([
            'title' => 'admin'
        ]);
        
        DB::table('user_roles')->insert([
            'title' => 'client'
        ]);

        $adminRoleId = DB::table('user_roles')
            ->where('title', 'admin')
            ->value('id');

        DB::table('users')->insert([
            'user_role_id' => $adminRoleId,
            'login' => 'Admin',
            'password' => 'KorokNET',
            // ...
        ]);
    }
}
```

Запустите сидер:
```
php artisan db:seed
```
