// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  modules: [
    '@nuxt/eslint',
    '@nuxt/image',
    '@nuxt/ui',
    '@nuxt/content',
  ],

  ssr: true,

  devtools: {
    enabled: false,
  },

  app: {
    baseURL: '/laravel-guides/',
    buildAssetsDir: 'assets',
  },

  css: ['~/assets/css/main.css'],

  content: {
    build: {
      markdown: {
        highlight: {
          langs: ['php', 'blade'],
        },

        toc: {
          searchDepth: 1,
        },
      },
    },
  },

  nitro: {
    preset: 'static',

    prerender: {
      crawlLinks: true,
      routes: ['/'],
      ignore: ['/admin'],
    },
  },

  eslint: {
    config: {
      stylistic: {
        semi: true,
        quotes: 'single',
      },
    },
  },

  icon: {
    provider: 'iconify',
  },
});
