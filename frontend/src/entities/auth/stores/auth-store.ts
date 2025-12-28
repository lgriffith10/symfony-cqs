import { defineStore } from 'pinia'

type AuthStoreState = {
  isAuthenticated: boolean
  isChecked: boolean
  email: string | null
}

export const useAuthStore = defineStore('auth', {
  state: (): AuthStoreState => ({
    isAuthenticated: false,
    isChecked: false,
    email: null,
  }),
  actions: {
    setIsAuthenticated(value: boolean, email: string | null) {
      this.isAuthenticated = value
      this.email = email
    },
  },
})
