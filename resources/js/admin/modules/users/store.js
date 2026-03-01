import { tableCrudStore } from '../../../ahmed-vue-kit/stores/tableCrudStore';

export const useUserStore = tableCrudStore(
  'userStore',
  'http://lara-vue-admin.test/api/v1/users'
);
