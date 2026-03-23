<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel App</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">

    <style>
        html {
            font-size: 1.25rem;
        }

        body {
            background: papayawhip;
        }

        nav {
            background: peachpuff;
        }

        main {
            background: ghostwhite;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            @include('navbar')
        </header>

        <main class="m-4 p-4 shadow rounded">
            <div class="messages">
                @include('message')
                @include('error')
            </div>

            @yield('content')
        </main>
    </div>

    <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
</body>
</html>
