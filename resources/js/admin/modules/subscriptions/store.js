import { useResourceStore } from '@kit/stores/useResourceStore';
import { SUBSCRIPTION_ENDPOINTS } from '@/data/endpoint';

// if specific extra need outside of the useResourceStore.
//parent will get priority
export const useSubscriptionStore = useResourceStore(
  'subscriptionStore',
  SUBSCRIPTION_ENDPOINTS.index,
  {
    // state: {
    //   tenantSettings: {
    //     country: 'ahmed', //{{ tenantStore.tenantSettings ?? '' }}
    //   },
    //   name: 'ahmed', //{{ tenantStore.tenantSettings ?? '' }}
    // },
    // getters: {
    //   tenantCount: (state) => state.rows.length,
    //   activeTenants: (state) => state.rows.filter((t) => t.active),
    // },
    // actions: {
    //   async fetchTenantSettings() {
    //     const res = await api.get('v1/tenant-settings');
    //     this.tenantSettings = res.data.data;
    //   },
    // },
  }
); // relative to VITE_API_URL;
