import { defineStore } from 'pinia';
import { LOGIN_ENDPOINT } from '../../data/endpoint';
import api from '../api/api';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    loading: false,
    user: null,
    subscription: null,
    permissions: [],
    features: [],
    initialized: false,
    subscriptionExpired: false,
    lastFetchTime: 0,

    token: localStorage.getItem('token') || null,
    tenant_id: localStorage.getItem('tenant_id') || null,
  }),

  getters: {
    isAuthenticated: (state) => !!state.token,
  },

  actions: {
    //----------------------------------------
    // Login
    //----------------------------------------
    async login(form) {
      this.loading = true;

      try {
        const res = await api.post(LOGIN_ENDPOINT.login, form);
        this.setAuth(res.data);
        await this.fetchMe(true);
        return res;
      } catch (error) {
        throw error.response?.data || error;
      } finally {
        this.loading = false;
      }
    },

    //----------------------------------------
    // Fetch logged user
    //----------------------------------------
    async fetchMe(force = false) {
      if (!this.token) {
        this.initialized = true;
        return null;
      }
      const now = Date.now();

      // use whey api performance will create problem
      // prevent API spam (10 sec cache)
      // if (!force && now - this.lastFetchTime < 10000) {
      //   // alert('Avoid Too Requests');
      //   return;
      // }

      try {
        const { data } = await api.get(LOGIN_ENDPOINT.user);

        this.user = data.user || null;
        this.subscription = data.subscription || null;
        this.permissions = data.permissions || [];
        this.features = data.features || [];

        // subscription expired detect
        // if (data.subscription?.is_expired) {
        //   this.subscriptionExpired = true;
        // } else {
        //   this.subscriptionExpired = false;
        // }

        this.lastFetchTime = now;
        this.initialized = true;

        return data;
      } catch (error) {
        console.error('fetchMe failed:', error);       

        // 401 → logout
        if (error.response.status === 401) {
          this.clearAuth();
        }

        if (
          error.response.status === 403 &&
          error.response.data?.error === 'SUBSCRIPTION_EXPIRED'
        ) {
          this.subscriptionExpired = true;
          this.subscription = error.response.data.subscription || null;
        }

        this.initialized = true;
        return null;
      }
    },

    //----------------------------------------
    // Feature check
    //----------------------------------------
    hasFeature(feature) {
      if (!feature) return true;
      return this.features.includes(feature);
    },

    //----------------------------------------
    // Permission check
    //----------------------------------------
    can(permission) {
      if (!permission) return true;
      return this.permissions.includes(permission);
    },

    //----------------------------------------
    // Unified access
    //----------------------------------------
    hasAccess(access) {
      if (!access) return true;

      if (this.isSystemAdmin()) return true;

      return this.can(access) && this.hasFeature(access);
    },

    //----------------------------------------
    // System admin bypass
    //----------------------------------------
    isSystemAdmin() {
      return this.user?.user_type === 'system_admin';
    },

    //----------------------------------------
    // Set auth after login
    //----------------------------------------
    setAuth(data) {
      this.user = data.user;
      this.token = data.token;
      this.tenant_id = data.tenant_id || null;

      localStorage.setItem('token', data.token);

      if (this.tenant_id) {
        localStorage.setItem('tenant_id', this.tenant_id);
      }

      api.defaults.headers.common['Authorization'] = `Bearer ${data.token}`;

      if (this.tenant_id) {
        api.defaults.headers.common['X-Tenant-ID'] = this.tenant_id;
      }
    },

    //----------------------------------------
    // Logout
    //----------------------------------------
    async logout() {
      try {
        if (this.token) {
          await api.post(LOGIN_ENDPOINT.logout);
        }
      } catch (error) {
        console.error('Logout API failed:', error);
      } finally {
        this.clearAuth();
      }
    },

    //----------------------------------------
    // Clear auth
    //----------------------------------------
    clearAuth() {
      this.user = null;
      this.token = null;
      this.tenant_id = null;

      localStorage.removeItem('token');
      localStorage.removeItem('tenant_id');

      delete api.defaults.headers.common['Authorization'];
      delete api.defaults.headers.common['X-Tenant-ID'];
    },
  },
});
