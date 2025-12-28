import { createApp } from 'vue'
import { createPinia } from 'pinia'
import '@/assets/index.css'
import 'vue-sonner/style.css'
import App from './App.vue'
import router from './plugins/router'
import AuthLayout from '@/layouts/AuthLayout.vue'
import { VueQueryPlugin } from '@tanstack/vue-query'

const app = createApp(App)

app.use(createPinia())
app.use(router).use(VueQueryPlugin)

app.component('AuthLayout', AuthLayout)

app.mount('#app')
