import { defineStore } from 'pinia'

export const useProductStore = defineStore('product', {
  state: () => ({
    product:{}
  }),
  actions: {
    setProduct(objProduct) {
      this.product = objProduct
    },
  },
})