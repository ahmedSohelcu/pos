export const CustomerMenus = [
  {
    key: 'customers',
    label: 'Customers',
    icon: 'bi bi-people-fill',
    permission: 'customer_access',
    items: [
      {
        name: 'customers.index',
        label: 'All Customers',
        permission: 'customer_view',
      },
      // {
      //   // name: 'customers.create',
      //   label: 'Add Customer',
      //   permission: 'customer_create',
      // },
      // {
      //   // name: 'customers.customer-groups',
      //   label: 'Customer Groups',
      //   permission: 'customer_group_view',
      // },
      // {
      //   // name: 'customers.loyalty-points',
      //   label: 'Loyalty Points',
      //   permission: 'loyalty_point_view',
      // },
    ],
  },
];
