import type { RouteRecordRaw } from 'vue-router'

export const routes: RouteRecordRaw[] = [
  {
    name: 'Home',
    path: '/',
    component: import('@/views/HomeView.vue'),
    meta: {
      isPublic: true,
      layout: 'AuthLayout',
    },
  },
]
