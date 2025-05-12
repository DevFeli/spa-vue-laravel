import { defineStore } from 'pinia'

export const usersStore = defineStore('user', {
  state: () => ({
    user:{}
  }),
  actions: {
    setUser(objUser) {
      this.user = objUser
    },
  },
})