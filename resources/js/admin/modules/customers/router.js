import CustomersIndex from './views/CustomersIndex.vue';

export default [
  {
    path: '/customers',
    name: 'customers.index',
    meta: {
      breadcrumb: 'All Customers',
      requiresAuth: true,
      layout: 'master',
      access: 'customer.view',
    },
    component: CustomersIndex,
  },
  // {
  //   path: '/users/:id/edit',
  //   name: 'users.edit',
  //   meta: {
  //     breadcrumb: 'Edit Users',
  //     requiresAuth: true,
  //     permission: 'users_edit',
  //   },
  //   component: UsersEdit,
  // },
];
