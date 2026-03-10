import { useResourceStore } from '@kit/stores/useResourceStore';
import { ROLE_ENDPOINTS, USER_ENDPOINTS } from '@/data/endpoint';
import api from '@kit/api/api';
import { notify } from '@kit/composables/useNotify';

// if specific extra need outside of the useResourceStore.
//parent will get priority
export const useUserStore = useResourceStore(
  'userStore',
  USER_ENDPOINTS.index,
  {
    state: {
      showRoleAssignModal: false,
      existingRoles: [],
      roles: [],
      user_id: null,
    },
    actions: {
      async fetchRoles() {
        const { data } = await api.get(ROLE_ENDPOINTS.selectableRoles);
        this.roles = data.data;
      },

      async fetchUserRoles(userId) {
        const { data } = await api.get(USER_ENDPOINTS.roles(userId));
        this.existingRoles = data.data;
      },

      async updateUserRoles() {
        const { data } = await api.patch(
          USER_ENDPOINTS.updateUserRoles(this.user_id),
          {
            roles: this.existingRoles,
          }
        );
        this.existingRoles = data.data;
        this.showRoleAssignModal = false;
        notify.success(data.message || 'Updated successfully.');

        // fetch main table data
        this.fetchData();
      },
    },
  }
); // relative to VITE_API_URL;
