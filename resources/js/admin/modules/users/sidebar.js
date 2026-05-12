export const UsersMenus = [
  {
    key: 'user-management',
    label: 'Users',
    icon: 'bi bi-shield-lock-fill',
    items: [
      {
        name: 'users.index',
        label: 'Users',
        access: 'user.view',
      },
      {
        name: 'roles.index',
        label: 'Roles',
        access: 'role.view',
      },
    ],
  },
];
