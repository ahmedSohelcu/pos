import { confirmDelete } from '@kit/composables/useDelete';
import { ATTRIBUTE_ENDPOINTS } from '@/data/endpoint';

export const getAttributeActions = (attributeStore) => [
  {
    label: (row) => {
      return `<i class="fas fa-plus-circle text-success me-2"></i>Create`;
    },
    handler: (row) => {
      attributeStore.mode = 'create';
      attributeStore.errors = {};
      attributeStore.selectedItem = {}; // reset form
      attributeStore.showModal = true;
    },
  },
  {
    label: '<i class="fas fa-edit text-warning me-2"></i> Edit',
    handler: async (row) => {
      attributeStore.showModal = true;
      attributeStore.errors = {};
      attributeStore.mode = 'edit';
      await attributeStore.show(ATTRIBUTE_ENDPOINTS.show(row.id));
    },
  },
  {
    label: '<i class="fas fa-trash text-danger me-2"></i> Delete',
    handler: async (row) => {
      await confirmDelete({
        apiUrl: ATTRIBUTE_ENDPOINTS.destroy(row.id),
        confirmTitle: `Delete ${row.name}?`,
        onSuccess: () => {
          attributeStore.fetchData(); // 🔥 correct refresh
        },
      });
    },
  },
];
