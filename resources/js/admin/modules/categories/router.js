import CategoryIndex from './views/CategoryIndex.vue';
import { categoryPermissions } from './permissions';

export default [
  {
    path: '/category',
    name: 'category.index',
    meta: {
      breadcrumb: 'All Category',
      layout: 'master',
      requiresAuth: true,
      // permission: 'category_view',
    },
    component: CategoryIndex,
  },
];
