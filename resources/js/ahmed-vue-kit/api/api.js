import axios from 'axios';
import { useAuthStore } from '../stores/authStore';
import router from '@/router';
import { notify } from '@kit/composables/useNotify';

// const baseURL = import.meta.env.VITE_API_URL;

// alert(baseURL);

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  timeout: 15000,
  headers: {
    Accept: 'application/json',
    'Content-Type': 'application/json',
  },
});

// 🔐 Attach Token Automatically
api.interceptors.request.use(
  (config) => {
    const auth = useAuthStore();

    if (auth.token) {
      config.headers.Authorization = `Bearer ${auth.token}`;
    }

    if (auth.tenant_id) {
      config.headers['X-Tenant-ID'] = auth.tenant_id;
    }

    return config;
  },
  (error) => Promise.reject(error)
);

// 🌍 Global Error Handling
api.interceptors.response.use(
  (response) => response,
  (error) => {
    const status = error.response?.status;

    if (status === 401) {
      const auth = useAuthStore();
      auth.logout();
      router.push('/login');
      notify.error('Session expired. Please login again.');
    }

    // Remove 403 and 500 from here
    // if (status === 403) {
    //   notify.error("You don't have permission.");
    // }

    // if (status === 500) {
    //   notify.error('Server error occurred.');
    // }

    if (!error.response) {
      notify.error('Network error. Please check your connection.');
    }

    return Promise.reject(error);
  }
);

export default api;
