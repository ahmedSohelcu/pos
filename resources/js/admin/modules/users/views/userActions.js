// tenantActions.js
import { confirmDelete } from '@kit/composables/useDelete';

export const getUserActions = (userStore) => [
  {
    label: (row) => {
      return `<i class="fas fa-plus-circle text-success me-2"></i>Create`;
    },
    handler: (row) => {
      userStore.mode = 'create';
      userStore.errors = {};
      userStore.selectedItem = {}; // reset form
      userStore.showModal = true;
    },
  },
  {
    label: '<i class="fas fa-edit text-warning me-2"></i> Edit',
    handler: async (row) => {
      userStore.showModal = true;
      userStore.errors = {};
      userStore.mode = 'edit';
      await userStore.show(
        row.id,
        'http://lara-vue-admin.test/api/v1/users'
      );

      console.log('userStore.selectedItem', userStore.selectedItem);
    },
  },
  {
    label: '<i class="fas fa-trash text-danger me-2"></i> Delete',
    handler: async (row) => {
      await confirmDelete({
        apiUrl: `http://lara-vue-admin.test/api/v1/users/${row.id}`,
        confirmTitle: `Delete ${row.name}?`,
        onSuccess: () => {
          userStore.fetchData(); // 🔥 correct refresh
        },
      });
    },
  },
];
