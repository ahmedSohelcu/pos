import SupplierIndex from "./views/SupplierIndex.vue";

export const SupplierRoutes = [
  {
    path: '/suppliers',
    name: 'suppliers.index',
    meta: {
      breadcrumb: 'Suppliers',
      requiresAuth: true,
      layout: 'master',
      access: 'supplier.view',
    },
    component: SupplierIndex,
  },
];

