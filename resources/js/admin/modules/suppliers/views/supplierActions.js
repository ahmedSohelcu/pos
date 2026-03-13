// tenantActions.js
import { confirmDelete } from '@kit/composables/useDelete';
import { CATEGORY_ENDPOINTS } from '@/data/endpoint';

export const getExpenseActions = (tenantStore) => [
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
      await tenantStore.show(CATEGORY_ENDPOINTS.show(row.id));
    },
  },
  {
    label: '<i class="fas fa-trash text-danger me-2"></i> Delete',
    handler: async (row) => {
      await confirmDelete({
        apiUrl: CATEGORY_ENDPOINTS.destroy(row.id),
        confirmTitle: `Delete ${row.name}?`,
        onSuccess: () => {
          tenantStore.fetchData(); // 🔥 correct refresh
        },
      });
    },
  },
];
