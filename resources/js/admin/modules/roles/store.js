import { useResourceStore } from '@kit/stores/useResourceStore';
import { ROLE_ENDPOINTS } from '@/data/endpoint';
import api from '../../../ahmed-vue-kit/api/api';
import { notify } from '@kit/composables/useNotify';

export const useRoleStore = useResourceStore(
  'roleStore',
  ROLE_ENDPOINTS.index,
  {
    state: {
      permissionModal: false,

      // all permission list
      permissions: [],
      // existing permissions and role
      form: {
        role_id: 'null',
        permissions: [],
      },
    },

    getters: {
      // tenantCount: (state) => state.rows.length,
      // activeTenants: (state) => state.rows.filter((t) => t.active),
    },

    actions: {
      async fetchPermissions() {
        const { data } = await api.get(ROLE_ENDPOINTS.permissions);
        this.permissions = data.data;
        console.log('this permissions  test', this.permissions);
      },

      async fetchPermissionsByRole(roleId) {
        const { data } = await api.get(
          ROLE_ENDPOINTS.permissionsByRole(roleId)
        );
        this.form.role_id = roleId;
        this.form.permissions = data.data;
      },

      async updatePermissionByRole(roleId, permissionIds) {
        console.log('updatePermissionByRole', roleId, permissionIds);
        try {
          const { data } = await api.post(
            ROLE_ENDPOINTS.updatePermissionsByRole(roleId), // pass roleId in URL
            {
              permissions: permissionIds, // send array of permission IDs
            }
          );

          // Update local store if needed
          this.permissionModal = false;
          this.form.permissions = data;

          console.log('updatePermissionByRole response', data);

          notify.success(data.message || 'Updated successfully.');
        } catch (error) {
          console.error(error);
        }
      },
    },
  }
); // relative to VITE_API_URL;
