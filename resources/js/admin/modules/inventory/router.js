import InventoryIndex from './views/InventoryIndex.vue';

export default [
  {
    path: '/inventory',
    name: 'inventory.index',
    meta: {
      breadcrumb: 'Stock Control',
      requiresAuth: true,
      layout: 'master',
      access: 'inventory.view',
    },
    component: InventoryIndex,
  },
];
