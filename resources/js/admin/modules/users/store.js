import { defineStore } from 'pinia'
import { UsersApi } from './api.js'

export const useUsersStore = defineStore('users', {
  state: () => ({
    items: [],
    loading: false,
    selectedItem: null
  }),
  actions: {
    async fetchItems() {
      this.loading = true
      const { data } = await UsersApi.all()
      this.items = data
      this.loading = false
    },
    setSelectedItem(item) {
      this.selectedItem = item
    }
  },
  getters: {
    totalItems: state => state.items.length
  }
})