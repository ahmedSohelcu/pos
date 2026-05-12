import UsersIndex from './views/UsersIndex.vue';
import RoleIndex from '../roles/views/RoleIndex.vue';

export default [
  {
    path: '/users',
    name: 'users.index',
    meta: {
      breadcrumb: 'All Users',
      requiresAuth: true,
      layout: 'master',
      access: 'user.view',
    },
    component: UsersIndex,
  },
  {
    path: '/roles',
    name: 'roles.index',
    meta: {
      breadcrumb: 'All Roles',
      layout: 'master',
      requiresAuth: true,
      access: 'role.view',
    },
    component: RoleIndex,
  },
];
