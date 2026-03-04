import { useResourceStore } from '@kit/stores/useResourceStore';
import { PLAN_ENDPOINTS } from '@/data/endpoint';

// if specific extra need outside of the useResourceStore.
//parent will get priority
export const usePlanStore = useResourceStore(
  'planStore',
  PLAN_ENDPOINTS.index,
  {
    // state: {
    //   billing_interval: 'monthly', //{{billing_interval}}
    //   name: 'ahmed', //{{ name}}
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
