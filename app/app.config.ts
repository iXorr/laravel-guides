export default defineAppConfig({
  ui: {
    colors: {
      primary: 'red',
      neutral: 'slate',
    },
  },

  seo: {
    siteName: 'Laravel Docs',
  },

  header: {
    title: '',
    to: '/',

    logo: {
      alt: '',
      light: '',
      dark: '',
    },

    search: true,
    colorMode: true,
    links: [{
      'icon': 'i-simple-icons-github',
      'to': 'https://github.com/iXorr/laravel-guides',
      'target': '_blank',
      'aria-label': 'GitHub',
    }],
  },

  toc: {
    title: 'Содержание',
  },
});
