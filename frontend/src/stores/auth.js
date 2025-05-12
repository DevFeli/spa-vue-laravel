import { defineStore } from 'pinia'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    token: '',
    user: false,
  }),
  actions: {
    setToken(tokenValue) {
      this.token = tokenValue
    },
    setUser(userValue) {
      this.user = userValue
    }
  },
})