import SalesIndex from './views/SalesIndex.vue';

export default [
  {
    path: '/sales',
    name: 'sales.index',
    meta: {
      breadcrumb: 'Sales History',
      requiresAuth: true,
      layout: 'master',
      access: 'sale.view',
    },
    component: SalesIndex,
  },
];
