import { brandPermissions } from './permissions';
import BrandIndex from './views/brandIndex.vue';

export default [
  {
    path: '/brand',
    name: 'brand.index',
    meta: {
      breadcrumb: 'All Brand',
      layout: 'master',
      requiresAuth: true,
      access: 'brand.view',
    },
    component: BrandIndex,
  },
];
