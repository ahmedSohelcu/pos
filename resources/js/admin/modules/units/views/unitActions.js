// tenantActions.js
import { confirmDelete } from '@kit/composables/useDelete';
import { UNIT_ENDPOINTS } from '@/data/endpoint';

export const getUnitActions = (unitStore) => [
  {
    label: (row) => {
      return `<i class="fas fa-plus-circle text-success me-2"></i>Create`;
    },
    handler: (row) => {
      unitStore.mode = 'create';
      unitStore.errors = {};
      unitStore.selectedItem = {}; // reset form
      unitStore.showModal = true;
    },
  },
  {
    label: '<i class="fas fa-edit text-warning me-2"></i> Edit',
    handler: async (row) => {
      unitStore.showModal = true;
      unitStore.errors = {};
      unitStore.mode = 'edit';
      await unitStore.show(UNIT_ENDPOINTS.show(row.id));
    },
  },
  {
    label: '<i class="fas fa-trash text-danger me-2"></i> Delete',
    handler: async (row) => {
      await confirmDelete({
        apiUrl: UNIT_ENDPOINTS.destroy(row.id),
        confirmTitle: `Delete ${row.name}?`,
        onSuccess: () => {
          unitStore.fetchData(); // 🔥 correct refresh
        },
      });
    },
  },
];
