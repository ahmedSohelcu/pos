// import TenantCreate from './views/TenantCreate.vue'
// import PlanIndex from './views/PlanIndex.vue'

import PlanIndex from './views/PlanIndex.vue';

export default [
  {
    path: '/plans',
    name: 'plan.index',
    meta: {
      layout: 'master',
      breadcrumb: 'All Plans',
      layout: 'master',
      requiresAuth: true,
      //  permission: 'tenant_view'
    },
    component: PlanIndex,
  },
];
