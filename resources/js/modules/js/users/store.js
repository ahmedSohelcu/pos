import { defineStore } from 'pinia'
import { Js/usersApi } from './api.js'

export const useJs/usersStore = defineStore('js/users', {
  state: () => ({ items: [], loading: false, selectedItem: null }),
  actions: {
    async fetchItems() {
      this.loading = true
      const { data } = await Js/usersApi.all()
      this.items = data
      this.loading = false
    },
    setSelectedItem(item) { this.selectedItem = item }
  },
  getters: { totalItems: state => state.items.length }
})