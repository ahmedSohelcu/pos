import TenantIndex from './views/TenantIndex.vue'
import TenantCreate from './views/TenantCreate.vue'

// import TenantCreate from './views/TenantCreate.vue'
// import PlanIndex from './views/PlanIndex.vue'


export default [
  {
    path: '/tenants',
    name: 'tenants.index',
    meta: {
        //  breadcrumb: 'All Tenants', layout: 'master', requiresAuth: true, permission: 'tenant_view' 
    },
    component: TenantIndex
  },
  {
    path: '/tenants/create',
    name: 'tenants.create',
    // meta: { breadcrumb: 'Create Tenant', layout: 'master', requiresAuth: true, permission: 'tenant_create' },
    component: TenantCreate
  },
//   {
//     path: '/tenants/subscriptions',
//     name: 'tenants.subscriptions',
//     meta: { breadcrumb: 'Subscriptions', layout: 'master', requiresAuth: true, permission: 'subscription_view' },
//     component: SubscriptionIndex
//   },
//   {
//     path: '/tenants/plans',
//     name: 'tenants.plans',
//     meta: { breadcrumb: 'Plans', layout: 'master', requiresAuth: true, permission: 'plan_view' },
//     component: PlanIndex
//   }
];