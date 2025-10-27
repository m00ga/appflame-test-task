// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2025-07-15',
  devtools: { enabled: true },
  srcDir: 'client/',
  dir: {
    public: 'public/nuxt',
  },

  app: {
    head: {
      title: 'Appflame Test Task'
    }
  },

  runtimeConfig: {
    public: {
      apiBase: import.meta.env.APP_URL,
      apiVersion: 'v1'
    }
  }
})
