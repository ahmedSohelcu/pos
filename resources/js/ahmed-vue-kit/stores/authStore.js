import { defineStore } from 'pinia';
import { LOGIN_ENDPOINT } from '../../data/endpoint';
import api from '../api/api';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    loading: false,
    user: null,
    token: localStorage.getItem('token') || null,
    tenant_id: localStorage.getItem('tenant_id') || null,
  }),

  getters: {
    isAuthenticated: (state) => !!state.token,
  },

  actions: {
    async login(form) {
      try {
        const res = await api.post(LOGIN_ENDPOINT.login, form);
        // console.log('res', res);
        this.token = res.data.token;
        this.user = res.data.user;
        localStorage.setItem('token', res.data.token);
        return res;
      } catch (error) {
        console.log('error', error);
        throw error.response.data;
      }
    },

    // fetch logged User data

    async fetchUser() {
      if (!this.token) return;
      try {
        const res = await api.get(LOGIN_ENDPOINT.user);

        this.user = res.data;
      } catch (e) {
        this.logout();
      }
    },
    setAuth(data) {
      this.user = data.user;
      this.token = data.token;
      this.tenant_id = data.tenant_id || null;

      localStorage.setItem('token', data.token);

      //added in api.js
      // axios.defaults.headers.common['Authorization'] =`Bearer ${res.data.token}`;

      if (data.tenant_id) {
        localStorage.setItem('tenant_id', data.tenant_id);
      }
    },

    async logout() {
      let response = null;
      try {
        response = await api.post(LOGIN_ENDPOINT.logout);
      } catch (error) {
        console.error('Logout API failed:', error);
      }

      // Clear state
      this.user = null;
      this.token = null;
      this.tenant_id = null;

      localStorage.removeItem('token');
      localStorage.removeItem('tenant_id');

      return response;
    },
  },
});
