import { tableCrudStore } from "../../../ahmed-vue-kit/stores/tableCrudStore";

export const useTenantStore = tableCrudStore(
  'tenantStore',
  'http://lara-vue-admin.test/api/v1/tenants'
);
