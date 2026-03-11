import axios from 'axios';
import { useAuthStore } from '../stores/authStore';
import { getActivePinia } from 'pinia';
import router from '@/router';
import { notify } from '@kit/composables/useNotify';

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  timeout: 15000,
  headers: {
    Accept: 'application/json',
    'Content-Type': 'application/json',
  },
  withCredentials: true,
});

api.interceptors.request.use((config) => {
  if (getActivePinia()) {
    const auth = useAuthStore();
    if (auth.token) config.headers.Authorization = `Bearer ${auth.token}`;
    if (auth.tenant_id) config.headers['X-Tenant-ID'] = auth.tenant_id;
  }
  return config;
});

api.interceptors.response.use(
  (response) => response,
  (error) => {
    const status = error.response?.status;

    if (status === 401 && getActivePinia()) {
      const auth = useAuthStore();
      if (auth.token) { // only if user has token
        auth.logout();
        router.push('/login');
        notify.error('Session expired. Please login again.');
      }
    }

    if (!error.response) {
      notify.error('Network error. Please check your connection.');
    }

    return Promise.reject(error);
  }
);

export default api;