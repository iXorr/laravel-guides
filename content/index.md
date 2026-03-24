---
seo:
  title: Laravel Guides
  description: Сжатое руководство по Laravel
---

::u-page-hero{class="dark:bg-gradient-to-b from-neutral-900 to-neutral-950"}
---
orientation: horizontal
---
#top
:hero-background

#title
Освойте [Laravel]{.text-primary}.

#description
Следуйте пошаговым инструкциям, изучайте лучшие практики на реальном примере, чтобы уверенно и быстро создавать монолитные веб-приложения.

#links
  :::u-button
  ---
  to: /main-course
  size: xl
  trailing-icon: i-lucide-arrow-right
  ---
  Перейти
  :::

  :::u-button
  ---
  icon: i-simple-icons-github
  color: neutral
  variant: outline
  size: xl
  to: https://github.com/iXorr/laravel-guides
  target: _blank
  ---
  Посмотреть на GitHub
  :::

#default
  :::prose-pre
  ---
  code: |
    composer create-project --prefer-dist laravel/laravel project-name
  filename: terminal
  ---

  ```bash [terminal]
  composer create-project laravel/laravel:^10 .
  cp .env.example .env
  php artisan key:generate
  php artisan migrate --seed
  php artisan serve
  ```
  :::
::

::u-page-section{class="dark:bg-neutral-950"}
#title
Создано для разрабов. Работает на Laravel.

#features
  :::u-page-feature
  ---
  icon: i-lucide-book
  ---
  #title
  Пошаговые руководства

  #description
  Каждая тема объясняется последовательно, ясно, с примерами и современными best practices, что ускоряет подготовку к экзамену.
  :::

  :::u-page-feature
  ---
  icon: i-lucide-terminal
  ---
  #title
  Практический пример

  #description
  На протяжении всего курса будет создаваться приложение, похожее на задания с демонстрационного экзамена.
  :::

  :::u-page-feature
  ---
  icon: i-lucide-key-round
  ---
  #title
  Лёгкое знакомство

  #description
  Цель методички - сопроводить и позволить написать первый сайт разработчику, который не знаком с Laravel, без углубления в сложные темы.
  :::
::

