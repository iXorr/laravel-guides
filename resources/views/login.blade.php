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
