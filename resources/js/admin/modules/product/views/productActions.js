// productActions.js
import { confirmDelete } from '../../../../ahmed-vue-kit/composables/useDelete';
import { PRODUCT_ENDPOINTS } from '../../../../data/endpoint';

export const getProductActions = (productStore, router) => [
  {
    label: (row) => {
      return `<i class="fas fa-plus-circle text-success me-2"></i>Create`;
    },
    handler: () => {
      router.push({ name: 'product.create' });
    },
  },
  {
    label: '<i class="fas fa-edit text-warning me-2"></i> Edit',
    handler: (row) => {
      router.push({ name: 'product.edit', params: { id: row.id } });
    },
  },
  {
    label: '<i class="fas fa-trash text-danger me-2"></i> Delete',
    handler: async (row) => {
      await confirmDelete({
        apiUrl: PRODUCT_ENDPOINTS.destroy(row.id),
        confirmTitle: `Delete ${row.name}?`,
        onSuccess: () => {
          productStore.fetchData(); // 🔥 correct refresh
        },
      });
    },
  },
];