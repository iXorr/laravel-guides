<nav class="navbar navbar-expand-lg rounded my-4 px-2 shadow">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('index') }}">Главная</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Авторизация</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">Регистрация</a>
            </li>
        @endguest

        @auth
            <li class="nav-item">
                <a class="nav-link" href="{{ route('courses.index') }}">Курсы</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('applications.index') }}">Заявки</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}">Выйти</a>
            </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
