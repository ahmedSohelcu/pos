import SubsriptionIndex from './views/SubscriptionIndex.vue';
import SubscriptionHistory from './views/SubscriptionHistory.vue';

export default [
  {
    path: '/subscriptions',
    name: 'subscription.index',
    meta: {
      layout: 'master',
      breadcrumb: 'Subscriptions',
      layout: 'master',
      requiresAuth: true,
      permission: 'view.subscription',
    },
    component: SubsriptionIndex,
  },
  {
    path: '/subscriptions-history',
    name: 'subscription.history',
    meta: {
      layout: 'master',
      //  breadcrumb: 'All Tenants', layout: 'master', requiresAuth: true, permission: 'tenant_view'
    },
    component: SubscriptionHistory,
  },
  // {
  //   path: '/tenants/create',
  //   name: 'tenants.create',
  //   // meta: { breadcrumb: 'Create Tenant', layout: 'master', requiresAuth: true, permission: 'tenant_create' },
  //   component: TenantCreate
  // },
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
