import { defineStore } from 'pinia';
import { LOGIN_ENDPOINT } from '../../data/endpoint';
import api from '../api/api';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    loading: false,
    user: null,
    subscription: null,
    permissions: [],
    initialized: false,

    token: localStorage.getItem('token') || null,
    tenant_id: localStorage.getItem('tenant_id') || null,
  }),

  getters: {
    isAuthenticated: (state) => !!state.token,
  },

  actions: {
    //----------------------------------------
    //Login
    //----------------------------------------
    async login(form) {
      this.loading = true;
      try {
        const res = await api.post(LOGIN_ENDPOINT.login, form);
        this.setAuth(res.data);
        return res;
      } catch (error) {
        throw error.response?.data || error;
      } finally {
        this.loading = false;
      }
    },

    //---------------------------------------------
    //** Get logged User Data via token **
    // used in api.js to set user data
    //---------------------------------------------
    async fetchMe() {
      // if no token don't call API
      if (!this.token) return null;

      try {
        const { data } = await api.get(LOGIN_ENDPOINT.user);

        this.user = data.user || null;
        this.subscription = data.subscription || null;
        this.permissions = data.permissions || [];

        return data;

      } catch (error) {
        console.error("fetchMe failed:", error);

        // optional: logout if token invalid
        if (error.response?.status === 401) {
          this.clearAuth(false);
        }

        return null;
      }
    },

    //-------------------------------------
    // check specific feature access
    // v-if="auth.hasFeature('create_invoice')
    //-------------------------------------
    hasFeature(feature) {
      return this.subscription?.features.includes(feature);
    },

    //-------------------------------------
    // check specific permission
    // v-if="auth.can('edit_users')
    //-------------------------------------
    can(permission) {
      return this.permissions.includes(permission);
    },

    //-------------------------------------
    // feature and permission bypass
    //for system admin
    //-------------------------------------
    isSystemAdmin() {
      return this.user?.user_type === 'system_admin';
    },

    //----------------------------------------
    // set auth data after successful login
    //----------------------------------------
    setAuth(data) {
      this.user = data.user;
      this.token = data.token;
      this.tenant_id = data.tenant_id || null;

      localStorage.setItem('token', data.token);

      if (this.tenant_id) localStorage.setItem('tenant_id', this.tenant_id);

      api.defaults.headers.common['Authorization'] = `Bearer ${data.token}`;
      if (this.tenant_id)
        api.defaults.headers.common['X-Tenant-ID'] = this.tenant_id;
    },

    //----------------------------------------
    //Logout
    //----------------------------------------
    async logout() {
      try {
        if (this.token) await api.post(LOGIN_ENDPOINT.logout);
      } catch (error) {
        console.error('Logout API failed:', error);
      } finally {
        this.clearAuth(true);
      }
    },

    //----------------------------------------
    //clear data after logout
    //----------------------------------------
    clearAuth(notifyFrontend = true) {
      this.user = null;
      this.token = null;
      this.tenant_id = null;

      localStorage.removeItem('token');
      localStorage.removeItem('tenant_id');

      // Remove axios defaults
      delete api.defaults.headers.common['Authorization'];
      delete api.defaults.headers.common['X-Tenant-ID'];

      if (notifyFrontend) {
        // optional: router.push('/login') can be handled in api.js interceptor
      }
    },
  },
});
