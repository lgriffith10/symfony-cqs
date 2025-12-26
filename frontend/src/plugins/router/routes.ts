import type { RouteRecordRaw } from 'vue-router'

export const routes: RouteRecordRaw[] = [
  {
    name: 'Register',
    path: '/register',
    component: import('@/views/auth/RegisterView.vue'),
    meta: {
      isPublic: true,
      layout: 'AuthLayout',
    },
  },
  {
    name: 'Home',
    path: '/',
    component: import('@/views/HomeView.vue'),
  },
]
