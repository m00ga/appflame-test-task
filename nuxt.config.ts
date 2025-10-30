// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2025-07-15',
  devtools: { enabled: true },
  srcDir: 'client/',
  dir: {
    public: 'public/nuxt',
  },

  modules: ['@nuxt/ui', 'dayjs-nuxt'],
  css: ['~/assets/css/main.css'],

  dayjs: {
    locales: ['en', 'uk'],
    plugins: ['relativeTime', 'utc', 'timezone'],
    defaultLocale: 'uk',
    defaultTimezone: 'Europe/Kyiv',
  },

  app: {
    head: {
      title: 'Appflame Test Task'
    }
  },

  runtimeConfig: {
    apiSecret: import.meta.env.API_SECRET,
    idempotentKey: import.meta.env.IDEMPOTENT_KEY,
    public: {
      apiBase: import.meta.env.APP_URL,
      apiVersion: 'api/v1',
      timezone: import.meta.env.APP_TIMEZONE
    }
  }
})
