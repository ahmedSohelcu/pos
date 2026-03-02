import {useResourceStore} from '@kit/stores/useResourceStore';

export const useUserStore = useResourceStore(
  'userStore',
  'http://lara-vue-admin.test/api/v1/users'
);
