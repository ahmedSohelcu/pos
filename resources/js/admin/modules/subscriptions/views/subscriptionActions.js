// tenantActions.js
import { confirmDelete } from '@kit/composables/useDelete';
import { SUBSCRIPTION_ENDPOINTS } from '@/data/endpoint';

export const getSubscriptionActions = (subscriptionStore) => [
  {
    label: (row) => {
      return `<i class="fas fa-plus-circle text-success me-2"></i>Create`;
    },
    handler: (row) => {
      subscriptionStore.mode = 'create';
      subscriptionStore.errors = {};
      subscriptionStore.selectedItem = {}; // reset form
      subscriptionStore.showModal = true;
    },
  },
  {
    label: '<i class="fas fa-edit text-warning me-2"></i> Edit',
    handler: async (row) => {
      subscriptionStore.showModal = true;
      subscriptionStore.errors = {};
      subscriptionStore.mode = 'edit';
      await subscriptionStore.show(SUBSCRIPTION_ENDPOINTS.show(row.id));
    },
  },
  {
    label: '<i class="fas fa-trash text-danger me-2"></i> Delete',
    handler: async (row) => {
      await confirmDelete({
        apiUrl: SUBSCRIPTION_ENDPOINTS.destroy(row.id),
        confirmTitle: `Delete ${row.name}?`,
        onSuccess: () => {
          subscriptionStore.fetchData(); // 🔥 correct refresh
        },
      });
    },
  },
];
