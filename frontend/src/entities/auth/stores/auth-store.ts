import { defineStore } from 'pinia'

type AuthStoreState = {
  isAuthenticated: boolean
}

export const useAuthStore = defineStore('auth', {
  state: (): AuthStoreState => ({
    isAuthenticated: false,
  }),
  actions: {
    setIsAuthenticated(value: boolean) {
      this.isAuthenticated = value
    },
  },
})
