export const UsersMenus = [
  {
    key: 'user-management',
    label: 'User Management',
    icon: 'bi bi-shield-lock-fill',
    permission: 'user_management_access',
    items: [
      {
        name: 'users.index',
        label: 'All Users',
        permission: 'user_view',
      },
      {
        name: 'users.create',
        label: 'Add User',
        permission: 'user_create',
      },
      {
        name: 'roles.index',
        label: 'Roles',
        permission: 'role_view',
      },
      // {
      //   name: 'component',
      //   // name: 'permissions.index',
      //   label: 'Permissions',
      //   permission: 'permission_view',
      // },
    ],
  },
];
