import Js/usersIndex from './views/Js/usersIndex.vue'
import Js/usersCreate from './views/Js/usersCreate.vue'
import Js/usersEdit from './views/Js/usersEdit.vue'

export default [
  { path: '/js/users', name: 'js/users.index', meta: { breadcrumb: 'All Js/users', requiresAuth: true }, component: Js/usersIndex },
  { path: '/js/users/create', name: 'js/users.create', meta: { breadcrumb: 'Add Js/users', requiresAuth: true }, component: Js/usersCreate },
  { path: '/js/users/:id/edit', name: 'js/users.edit', meta: { breadcrumb: 'Edit Js/users', requiresAuth: true }, component: Js/usersEdit }
]