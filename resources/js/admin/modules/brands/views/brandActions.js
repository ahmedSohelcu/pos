// tenantActions.js
import { confirmDelete } from '@kit/composables/useDelete';
import { BRAND_ENDPOINTS } from '@/data/endpoint';

export const getBrandActions = (brandStore) => [
  {
    label: (row) => {
      return `<i class="fas fa-plus-circle text-success me-2"></i>Create`;
    },
    handler: (row) => {
      brandStore.mode = 'create';
      brandStore.errors = {};
      brandStore.selectedItem = {}; // reset form
      brandStore.showModal = true;
    },
  },
  {
    label: '<i class="fas fa-edit text-warning me-2"></i> Edit',
    handler: async (row) => {
      brandStore.showModal = true;
      brandStore.errors = {};
      brandStore.mode = 'edit';
      await brandStore.show(BRAND_ENDPOINTS.show(row.id));
    },
  },
  {
    label: '<i class="fas fa-trash text-danger me-2"></i> Delete',
    handler: async (row) => {
      await confirmDelete({
        apiUrl: BRAND_ENDPOINTS.destroy(row.id),
        confirmTitle: `Delete ${row.name}?`,
        onSuccess: () => {
          brandStore.fetchData(); // 🔥 correct refresh
        },
      });
    },
  },
];
