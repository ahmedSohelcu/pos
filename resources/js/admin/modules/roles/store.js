import { useResourceStore } from '@kit/stores/useResourceStore';
import { ROLE_ENDPOINTS } from '@/data/endpoint';
import { get } from 'jquery';
import api from '../../../ahmed-vue-kit/api/api';

export const useRoleStore = useResourceStore(
  'roleStore',
  ROLE_ENDPOINTS.index,
  {
    state: {
      permissionModal: false,
      // all permission list
      permissions: [],
      form: {
        role_id: 1,
        // already assigned permissions
        permissions: [1, 2, 3, 7, 9, 20, 22, 25, 26, 27, 28, 29],
      },
    },

    getters: {
      // tenantCount: (state) => state.rows.length,
      // activeTenants: (state) => state.rows.filter((t) => t.active),
    },

    actions: {
      async fetchPermissions(role_id) {
        const { data } = await api.get(ROLE_ENDPOINTS.permissions(role_id));
        this.permissions = data.data;
      },
    },
  }
); // relative to VITE_API_URL;
