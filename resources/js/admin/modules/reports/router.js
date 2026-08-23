import ReportsIndex from './views/ReportsIndex.vue';

export default [
  {
    path: '/reports',
    name: 'reports.index',
    meta: {
      breadcrumb: 'Reports & Analytics',
      requiresAuth: true,
      layout: 'master',
      access: 'reports.view',
    },
    component: ReportsIndex,
  },
];
