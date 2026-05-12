import TenantIndex from './views/TenantIndex.vue';
import TenantCreate from './views/TenantCreate.vue';

// import TenantCreate from './views/TenantCreate.vue'
// import PlanIndex from './views/PlanIndex.vue'

export default [
  {
    path: '/tenants',
    name: 'tenants.index',
    meta: {
      breadcrumb: 'All Tenants',
      layout: 'master',
      requiresAuth: true,
      access: 'tenant.view',
    },
    component: TenantIndex,
  },
];
