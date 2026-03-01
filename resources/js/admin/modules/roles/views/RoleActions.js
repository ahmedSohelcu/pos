// tenantActions.js
import { confirmDelete } from '@kit/composables/useDelete';

export const getRoleActions = (roleStore) => [
  {
    label: (row) => {
      return `<i class="fas fa-plus-circle text-success me-2"></i>Create`;
    },
    handler: (row) => {
      roleStore.mode = 'create';
      roleStore.errors = {};
      roleStore.selectedItem = {}; // reset form
      roleStore.showModal = true;
    },
  },
  {
    label: '<i class="fas fa-edit text-warning me-2"></i> Edit',
    handler: async (row) => {
      roleStore.showModal = true;
      roleStore.errors = {};
      roleStore.mode = 'edit';
      await roleStore.show(row.id, 'http://lara-vue-admin.test/api/v1/roles');

      console.log('roleStore.selectedItem', roleStore.selectedItem);
    },
  },
  {
    label: '<i class="fas fa-trash text-danger me-2"></i> Delete',
    handler: async (row) => {
      await confirmDelete({
        apiUrl: `http://lara-vue-admin.test/api/v1/roles/${row.id}`,
        confirmTitle: `Delete ${row.name}?`,
        onSuccess: () => {
          roleStore.fetchData(); // 🔥 correct refresh
        },
      });
    },
  },
];
