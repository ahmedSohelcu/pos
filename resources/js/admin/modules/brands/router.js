import { brandPermissions } from './permissions';
import BrandIndex from './views/brandIndex.vue';

export default [
  {
    path: '/brand',
    name: 'brand.index',
    meta: {
      breadcrumb: 'All Brand',
      // requiresAuth: true,
      // permission: 'brand_view',
    },
    component: BrandIndex,
  },
];
