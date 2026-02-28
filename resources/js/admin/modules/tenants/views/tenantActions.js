// tenantActions.js
import { confirmDelete } from '@kit/composables/useDelete';

export const getTenantActions = (tenantStore) => [
  {
    label: (row) => {
      return `<i class="fas fa-plus-circle text-success me-2"></i>Create`;
    },
    handler: (row) => {
      tenantStore.mode = 'create';
      tenantStore.errors = {};
      tenantStore.selectedItem = {}; // reset form
      tenantStore.showModal = true;
    },
  },
  {
    label: '<i class="fas fa-edit text-warning me-2"></i> Edit',
    handler: async (row) => {
      tenantStore.showModal = true;
      tenantStore.errors = {};
      tenantStore.mode = 'edit';
      await tenantStore.show(
        row.id,
        'http://lara-vue-admin.test/api/v1/tenants'
      );

      console.log('tenantStore.selectedItem', tenantStore.selectedItem);
    },
  },
  {
    label: '<i class="fas fa-trash text-danger me-2"></i> Delete',
    handler: async (row) => {
      await confirmDelete({
        apiUrl: `http://lara-vue-admin.test/api/v1/tenants/${row.id}`,
        confirmTitle: `Delete ${row.name}?`,
        onSuccess: () => {
          tenantStore.fetchData(); // 🔥 correct refresh
        },
      });
    },
  },
];
