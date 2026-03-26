# Laravel Guides

![Nuxt](https://img.shields.io/badge/Nuxt-00DC82.svg?style=for-the-badge&logo=nuxt.js&logoColor=white)
![Vue.js](https://img.shields.io/badge/Vue.js-%2335495e.svg?style=for-the-badge&logo=vuedotjs&logoColor=%234FC08D)
![Tailwind CSS](https://img.shields.io/badge/Tailwind%20CSS-%2338B2AC.svg?style=for-the-badge&logo=tailwind-css&logoColor=white)
![TypeScript](https://img.shields.io/badge/TypeScript-%23007ACC.svg?style=for-the-badge&logo=typescript&logoColor=white)
## Описание

**Laravel Guides** — это современный документационный сайт, созданный с помощью Nuxt и Nuxt Content. Он содержит сжатое, но полное руководство по Laravel с пошаговыми инструкциями, лучшими практиками и реальными примерами для создания монолитных веб-приложений.

Сайт генерируется как статический контент (SSG) и может быть размещен на любом хостинге с поддержкой статических сайтов.

## 🚀 Быстрый старт

### Требования
- **Node.js** >= 18.x
- **pnpm** >= 10.x (или npm/yarn)

### Установка зависимостей

```bash
pnpm install
```

### Локальная разработка

```bash
pnpm run dev
```

Сайт будет доступен по адресу `http://localhost:3000`

## 📦 Сборка

### Production сборка

```bash
pnpm run build
```

## Добавление нового контента

Контент хранится в папке `content/` в формате Markdown. Для добавления новой страницы:

1. Создайте файл с расширением `.md` в соответствующей папке
2. Добавьте фронтметр (meta информацию) в начало файла:

```markdown
---
seo:
  title: Название страницы
  description: Описание для SEO
---

# Заголовок

Содержание...
```

3. Структура папок автоматически преобразуется в URL. Числовой префикс определяет порядок в навигации.

Примеры:
- `content/index.md` → `/`
- `content/1.main-course/1.index.md` → `/main-course`
- `content/1.main-course/2.chapter.md` → `/main-course/chapter`
