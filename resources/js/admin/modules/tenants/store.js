import { useResourceStore } from '@kit/stores/useResourceStore';

export const useTenantStore = useResourceStore(
  'tenantStore',
  'v1/tenants' // relative to VITE_API_URL
);
