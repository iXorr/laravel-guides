// resources/views/users.blade.php

@props(['users']) // В этот шаблон передаётся массив юзеров

@if ($users->isNotEmpty())

<table>
    <thead>
        <th>ID</th>
        <th>Имя</th>
        <th>Фамилия</th>
        <th>Возраст</th>
    </thead>

    <tbody>
        @foreach ($users as $user) <!-- Обычный перебор юзеров -->
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->first_name }}</td>
                <td>{{ $user->last_name }}</td>
                <td>{{ $user->age }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@else

<p>Нет пользователей</p>

@endif
