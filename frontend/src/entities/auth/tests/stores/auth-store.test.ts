import { beforeEach, describe, expect, test } from 'vitest'
import { createPinia, setActivePinia } from 'pinia'
import { useAuthStore } from '@/entities/auth/stores/auth-store.ts'

describe('AuthStore', () => {
  beforeEach(() => {
    setActivePinia(createPinia())
  })

  test('should set isAuthenticated to given value', () => {
    // Arrange
    const authStore = useAuthStore()

    // Act
    authStore.setIsAuthenticated(true)

    // Assert
    expect(authStore.isAuthenticated).toBeTruthy()
  })

  test('should have default value to false', () => {
    // Arrange
    const authStore = useAuthStore()

    // Assert && act
    expect(authStore.isAuthenticated).toBeFalsy()
    expect(authStore.isChecked).toBeFalsy()
  })
})
