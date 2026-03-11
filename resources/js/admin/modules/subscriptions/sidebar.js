import { TenantPermissions } from './permissions';

export const SubscriptionMenus = [
  {
    key: 'subscription',
    label: 'Subscription',
    icon: 'fas fa-file-invoice-dollar', // subscription icon
    // permission: 'tenant_access',
    items: [
      {
        name: 'plan.index',
        label: 'Manage Plans',
        icon: 'fas fa-list',
      },
      {
        name: 'subscription.index',
        label: 'Active Subscription',
        icon: 'fas fa-plus-circle',
      },
      {
        name: 'subscription.history',
        label: 'Subscription History',
        icon: 'fas fa-history',
      },
    ],
  },
];
