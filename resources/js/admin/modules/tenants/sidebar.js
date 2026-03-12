export const TenantMenus = [
  {
    key: 'tenant',
    label: 'Tenants',
    icon: 'bi bi-building',
    items: [
      {
        name: 'tenants.index',
        label: 'Manage Tenants',
        access: 'tenant.view',
      },
    ],
  },
];
