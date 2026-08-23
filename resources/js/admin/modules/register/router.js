import RegisterIndex from './views/RegisterIndex.vue';

export default [
  {
    path: '/register',
    name: 'register.index',
    meta: {
      breadcrumb: 'Cash Register',
      requiresAuth: true,
      layout: 'master',
      access: 'register.view',
    },
    component: RegisterIndex,
  },
];
