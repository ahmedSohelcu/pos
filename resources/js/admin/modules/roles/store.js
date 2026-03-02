import {useResourceStore} from '@kit/stores/useResourceStore';

export const useRoleStore = useResourceStore(
  'roleStore',
  'http://lara-vue-admin.test/api/v1/roles'
);
