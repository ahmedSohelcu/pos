import { TenantPermissions } from './permissions';

export const SubscriptionMenus = [
  {
    key: 'subscription',
    label: 'Subscription',
    icon: 'fas fa-file-invoice-dollar', // subscription icon
    items: [
      {
        name: 'plan.index',
        label: 'Manage Plans',
        icon: 'fas fa-list',
        access: 'view.plan',
      },
      {
        name: 'subscription.index',
        label: 'Active Subscription',
        icon: 'fas fa-plus-circle',
        access: 'view.subscription',
      },
      {
        name: 'subscription.history',
        label: 'Subscription History',
        icon: 'fas fa-history',
        access: 'view.subscription',
      },
    ],
  },
];
