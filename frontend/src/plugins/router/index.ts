import { createRouter, createWebHistory } from 'vue-router'
import { routes } from '@/plugins/router/routes.ts'
import { useAuthStore } from '@/entities/auth/stores/auth-store.ts'
import { me } from '@/entities/auth/services'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [...routes],
})

router.beforeEach(async (to, from) => {
  const authStore = useAuthStore()

  if (!authStore.isAuthenticated && !authStore.isChecked) {
    try {
      const data = await me()
      if (data) {
        authStore.setIsAuthenticated(true, data.email)

        return from.meta.isPublic ? { name: 'Home' } : undefined
      }
    } catch {
      return { name: 'Login' }
    } finally {
      authStore.isChecked = true
    }
  }

  if (!authStore.isAuthenticated && !to.meta.isPublic) {
    return { name: 'Login' }
  }

  if (authStore.isAuthenticated && to.meta.isPublic) {
    return { name: 'Home' }
  }

  return
})

export default router
