import PosIndex from './views/PosIndex.vue';

export default [
  {
    path: '/pos',
    name: 'pos.index',
    meta: {
      breadcrumb: 'POS Terminal',
      requiresAuth: true,
      layout: 'master',
    },
    component: PosIndex,
  },
];
