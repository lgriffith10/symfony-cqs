import { createRouter, createWebHistory } from 'vue-router'
import { routes } from '@/plugins/router/routes.ts'
import { useAuthStore } from '@/entities/auth/stores/auth-store.ts'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [...routes],
})

router.beforeEach((to, from, next) => {
  const { isAuthenticated } = useAuthStore()

  if (!isAuthenticated && !to.meta.isPublic) {
    return next({ name: 'Login' })
  }

  if (isAuthenticated && to.meta.isPublic) {
    return next({ name: 'Home' })
  }

  return next()
})

export default router
