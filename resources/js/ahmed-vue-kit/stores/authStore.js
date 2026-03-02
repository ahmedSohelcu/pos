import { defineStore } from "pinia";

export const useAuthStore = defineStore("auth", {
  state: () => ({
    user: null,
    token: localStorage.getItem("token") || null,
    tenant_id: localStorage.getItem("tenant_id") || null,
  }),

  getters: {
    isAuthenticated: (state) => !!state.token,
  },

  actions: {
    setAuth(data) {
      this.user = data.user;
      this.token = data.token;
      this.tenant_id = data.tenant_id || null;

      localStorage.setItem("token", data.token);

      if (data.tenant_id) {
        localStorage.setItem("tenant_id", data.tenant_id);
      }
    },

    logout() {
      this.user = null;
      this.token = null;
      this.tenant_id = null;

      localStorage.removeItem("token");
      localStorage.removeItem("tenant_id");
    },
  },
});