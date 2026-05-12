// tenantActions.js
import { confirmDelete } from '@kit/composables/useDelete';
import { CUSTOMER_ENDPOINTS } from '../../../../data/endpoint';

export const getCustomerActions = (customerStore) => [
  {
    label: (row) => {
      return `<i class="fas fa-plus-circle text-success me-2"></i>Create`;
    },
    handler: (row) => {
      customerStore.mode = 'create';
      customerStore.errors = {};
      customerStore.selectedItem = {}; // reset form
      customerStore.showModal = true;
    },
  },
  {
    label: '<i class="fas fa-edit text-warning me-2"></i> Edit',
    handler: async (row) => {
      customerStore.showModal = true;
      customerStore.errors = {};
      customerStore.mode = 'edit';
      await customerStore.show(CUSTOMER_ENDPOINTS.show(row.id));

      console.log('customerStore.selectedItem', customerStore.selectedItem);
    },
  },
  {
    label: '<i class="fas fa-trash text-danger me-2"></i> Delete',
    handler: async (row) => {
      await confirmDelete({
        apiUrl: CUSTOMER_ENDPOINTS.destroy(row.id),
        confirmTitle: `Delete ${row.name}?`,
        onSuccess: () => {
          customerStore.fetchData(); // 🔥 correct refresh
        },
      });
    },
  },
];
