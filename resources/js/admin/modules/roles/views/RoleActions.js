// tenantActions.js
import { confirmDelete } from '@kit/composables/useDelete';
import api from '@kit/api/api';
import { ROLE_ENDPOINTS } from '@/data/endpoint';

export const getRoleActions = (roleStore) => [
  {
    label: '<i class="fas fa-key text-warning p-2"></i> Permission',
    handler: (row) => {
      // roleStore.errors = {};
      // roleStore.selectedItem = {}; // reset form
      // roleStore.fetchPermissions(row.id);
      roleStore.fetchPermissions(row.id);
      roleStore.permissionModal = true;
    },
  },
  {
    label: '<i class="fas fa-edit text-warning me-2"></i> Edit Role',
    handler: async (row) => {
      roleStore.showModal = true;
      roleStore.errors = {};
      roleStore.mode = 'edit';
      const abc = await roleStore.show(ROLE_ENDPOINTS.show(row.id));
    },
  },
  {
    label: '<i class="fas fa-trash text-danger me-2"></i> Delete',
    handler: async (row) => {
      await confirmDelete({
        apiUrl: ROLE_ENDPOINTS.destroy(row.id),
        confirmTitle: `Delete ${row.name}?`,
        onSuccess: () => {
          roleStore.fetchData(); // 🔥 correct refresh
        },
      });
    },
  },
];
