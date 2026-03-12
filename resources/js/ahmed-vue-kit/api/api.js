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

// -----------------------------
// Request Interceptor
// -----------------------------
api.interceptors.request.use((config) => {
  if (getActivePinia()) {
    const auth = useAuthStore();

    if (auth.token) {
      config.headers.Authorization = `Bearer ${auth.token}`;
    }

    if (auth.tenant_id) {
      config.headers['X-Tenant-ID'] = auth.tenant_id;
    }
  }

  return config;
});

// -----------------------------
// Response Interceptor
// -----------------------------
api.interceptors.response.use(
  (response) => response,

  async (error) => {
    const status = error.response?.status;
    const errorCode = error.response?.data?.error;

    if (!getActivePinia()) {
      return Promise.reject(error);
    }

    const auth = useAuthStore();

    //----------------------------------
    // 401 → Session Expired
    //----------------------------------
    if (status === 401) {
      if (auth.token && router.currentRoute.value.name !== 'Login') {
        await auth.logout();

        notify.error('Session expired. Please login again.');

        router.push({ name: 'Login' });
      }
    }

    //----------------------------------
    // 403 → Subscription Expired
    //----------------------------------
    if (status === 403 && errorCode === 'SUBSCRIPTION_EXPIRED') {
      auth.subscriptionExpired = true;
      const subscription = error.response.data.subscription || null;
      auth.subscription = subscription;
      // extract features safely
      auth.features = subscription?.plan?.features?.map((f) => f.name) || [];

      // avoid redirect loop
      //যদি user ইতিমধ্যে SubscriptionExpired page এ থাকে, তাহলে আবার redirect করবে না।
      if (
        router.currentRoute.value.name !== 'SubscriptionExpired' &&
        !auth.subscriptionExpired
      ) {
        router.push({ name: 'SubscriptionExpired' });
      }
    }

    //----------------------------------
    // Network Error
    //----------------------------------
    if (!error.response) {
      notify.error('Network error. Please check your internet connection.');
    }

    return Promise.reject(error);
  }
);

export default api;
