import { createApp } from 'vue'
import { createPinia } from 'pinia'
import PrimeVue from 'primevue/config'
import Aura from '@primeuix/themes/aura'

import '@/assets/index.css'

import App from './App.vue'
import router from './plugins/router'
import AuthLayout from '@/plugins/router/AuthLayout.vue'

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(PrimeVue, {
  theme: {
    preset: Aura,
  },
})

app.component('AuthLayout', AuthLayout)

app.mount('#app')
