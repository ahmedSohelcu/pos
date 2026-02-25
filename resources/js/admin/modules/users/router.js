import UsersIndex from './views/UsersIndex.vue';
import RoleIndex from './views/RolesIndex.vue';
import UserCreate from './views/UsersCreate.vue';
import UsersEdit from './views/UsersEdit.vue';

export default [
  {
    path: '/users',
    name: 'users.index',
    meta: {
      breadcrumb: 'All Users',
      // requiresAuth: true,
      permission: 'users_view',
    },
    component: UsersIndex,
  },
  {
    path: '/users/create',
    name: 'users.create',
    meta: {
      breadcrumb: 'Add Users',
      // requiresAuth: true,
      // permission: 'users_create',
    },
    component: UserCreate,
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
  {
    path: '/roles',
    name: 'roles.index',
    meta: {
      breadcrumb: 'All Roles',
      // requiresAuth: true,
      // permission: 'roles_view',
    },
    component: RoleIndex,
  },
];
