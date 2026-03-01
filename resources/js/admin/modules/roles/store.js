import { tableCrudStore } from "../../../ahmed-vue-kit/stores/tableCrudStore";

export const useRoleStore = tableCrudStore(
  'roleStore',
  'http://lara-vue-admin.test/api/v1/roles'
);
