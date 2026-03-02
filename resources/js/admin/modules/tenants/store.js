import { tableCrudStore } from '../../../ahmed-vue-kit/stores/tableCrudStore';

export const useTenantStore = tableCrudStore(
  'tenantStore',
  'v1/tenants' // relative to VITE_API_URL
);
