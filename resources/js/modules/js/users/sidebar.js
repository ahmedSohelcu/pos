export const Js/usersMenus = [
  {
    key: 'js/users',
    label: 'Js/users',
    icon: 'bi bi-people-fill',
    permission: 'js/users_access',
    items: [
      { name: 'js/users.index', label: 'All Js/users', permission: 'js/users_view' },
      { name: 'js/users.create', label: 'Add Js/users', permission: 'js/users_create' }
    ]
  }
]