import { TenantPermissions } from './permissions';

export const TenantMenus = [
  {
    key: 'tenants',
    label: 'Tenants',
    icon: 'bi bi-building',
    permission: 'tenant_access',
    items: [
      {
        name: 'tenants.index',
        label: 'Manage Tenants',
        permission: 'tenant_view',
      },
      // {
      //   name: 'tenants.create',
      //   label: 'Create Tenant',
      //   permission: 'tenant_create'
      // },
      // {
      //   name: 'tenants.subscriptions',
      //   label: 'Subscriptions',
      //   permission: 'subscription_view'
      // },
      // {
      //   name: 'tenants.plans',
      //   label: 'Plans',
      //   permission: 'plan_view'
      // }
    ],
  },
];
