import { unitPermissions } from './permissions';
import UnitdIndex from './views/unitIndex.vue';

export default [
  {
    path: '/unit',
    name: 'unit.index',
    meta: {
      breadcrumb: 'All unit',
      // requiresAuth: true,
      // permission: 'unit_view',
    },
    component: UnitdIndex,
  },
];
