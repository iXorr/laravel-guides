export default defineAppConfig({
  ui: {
    colors: {
      primary: 'red',
      neutral: 'slate'
    },

    footer: {
      slots: {
        root: 'border-t border-default',
        left: 'text-sm text-muted'
      }
    }
  },

  seo: {
    siteName: 'Nuxt Docs Template'
  },

  header: {
    title: '',
    to: '/',

    logo: {
      alt: '',
      light: '',
      dark: ''
    },

    search: true,
    colorMode: true,
    links: [{
      'icon': 'i-simple-icons-github',
      'to': 'https://github.com/iXorr/laravel-guides',
      'target': '_blank',
      'aria-label': 'GitHub'
    }]
  },

  footer: {
    credits: `Методичка по дем. экзамену • © ${new Date().getFullYear()}`,
    colorMode: false
  },

  toc: {
    title: 'Содержание'
  }
})
