// src/data/endpoints.js
import { route } from 'ziggy-js';

/*
|--------------------------------------------------------------------------
| Global
|--------------------------------------------------------------------------
*/

// export const STATUS_ENDPOINTS = {
//   selectable: route('selectable_statuses', { type: 'common' }),
// };

export const STATUS_ENDPOINTS = {
  selectable: (type = 'common') => route('selectable_statuses', { type }),
};
/*
// use 
<BaseSelect
  :getApiRoute="STATUS_ENDPOINTS.selectable('tenant')"
  select2
  label="Tenant"
  v-model="model.tenant_id"
  :error="errors.tenant_id"
  name="tenant_id"
  placeholder="Choose Tenant"
/>*

/*
|--------------------------------------------------------------------------
| Login logout endpoints
|--------------------------------------------------------------------------
*/
export const LOGIN_ENDPOINT = {
  login: route('api.login'),
  logout: route('api.logout'),
  user: route('api.me'),
};

/*
|--------------------------------------------------------------------------
| brand
|--------------------------------------------------------------------------
*/
export const BRAND_ENDPOINTS = {
  index: route('api.brand.index'),
  store: route('api.brand.store'),
  show: (id) => route('api.brand.show', { brand: id }),
  update: (id) => route('api.brand.update', { brand: id }),
  destroy: (id) => route('api.brand.destroy', { brand: id }),
};

/*
|--------------------------------------------------------------------------
| category
|--------------------------------------------------------------------------
*/
export const CATEGORY_ENDPOINTS = {
  index: route('api.category.index'),
  store: route('api.category.store'),
  show: (id) => route('api.category.show', { category: id }),
  update: (id) => route('api.category.update', { category: id }),
  destroy: (id) => route('api.category.destroy', { category: id }),
};

/*
|--------------------------------------------------------------------------
| Customer
|--------------------------------------------------------------------------
*/
export const CUSTOMER_ENDPOINTS = {
  index: route('api.customer.index'),
  store: route('api.customer.store'),
  show: (id) => route('api.customer.show', { customer: id }),
  update: (id) => route('api.customer.update', { customer: id }),
  destroy: (id) => route('api.customer.destroy', { customer: id }),
};

/*
|--------------------------------------------------------------------------
| Subscription
|--------------------------------------------------------------------------
*/
export const SUBSCRIPTION_ENDPOINTS = {
  index: route('api.subscription.index'),
  store: route('api.subscription.store'),
  show: (id) => route('api.subscription.show', { subscription: id }),
  update: (id) => route('api.subscription.update', { subscription: id }),
  destroy: (id) => route('api.subscription.destroy', { subscription: id }),
};

/*
|--------------------------------------------------------------------------
| Plan
|--------------------------------------------------------------------------
*/
export const PLAN_ENDPOINTS = {
  index: route('api.plan.index'),
  store: route('api.plan.store'),
  show: (id) => route('api.plan.show', { plan: id }),
  update: (id) => route('api.plan.update', { plan: id }),
  destroy: (id) => route('api.plan.destroy', { plan: id }),
  selectable: route('api.selectable_plans'),

  features: route('api.features'),
  featuresByPlan: (plan_id) => route('api.plan.features', { plan: plan_id }),
  updateFeaturesByPlan: (plan_id) =>
    route('api.plan.features.update', { plan: plan_id }),
};

/*
|--------------------------------------------------------------------------
| Role
|--------------------------------------------------------------------------
*/
export const ROLE_ENDPOINTS = {
  selectableRoles: route('api.selectable_roles'),
  index: route('api.role.index'),
  store: route('api.role.store'),
  show: (id) => route('api.role.show', { role: id }),
  update: (id) => route('api.role.update', { role: id }),
  destroy: (id) => route('api.role.destroy', { role: id }),
  permissions: route('api.permissions'),
  permissionsByRole: (role_id) =>
    route('api.role.permissions', { role: role_id }),
  updatePermissionsByRole: (role_id) =>
    route('api.role.permissions.update', { role: role_id }),
};

/*
|--------------------------------------------------------------------------
| Expense Category
|--------------------------------------------------------------------------
*/
export const EXPENSE_CATEGORY_ENDPOINTS = {
  index: route('api.expense_category.index'),
  store: route('api.expense_category.store'),
  show: (id) => route('api.expense_category.show', { expense_category: id }),
  update: (id) =>
    route('api.expense_category.update', { expense_category: id }),
  destroy: (id) =>
    route('api.expense_category.destroy', { expense_category: id }),
  selectable: route('api.selectable_expense_categories'),
};

/*
|--------------------------------------------------------------------------
| Expense
|--------------------------------------------------------------------------
*/
export const EXPENSE_ENDPOINTS = {
  index: route('api.expense.index'),
  store: route('api.expense.store'),
  show: (id) => route('api.expense.show', { expense: id }),
  update: (id) => route('api.expense.update', { expense: id }),
  destroy: (id) => route('api.expense.destroy', { expense: id }),
};

/*
|--------------------------------------------------------------------------
| Tenant
|--------------------------------------------------------------------------
*/
export const TENANT_ENDPOINTS = {
  index: route('api.tenant.index'),
  store: route('api.tenant.store'),
  show: (id) => route('api.tenant.show', { tenant: id }),
  update: (id) => route('api.tenant.update', { tenant: id }),
  destroy: (id) => route('api.tenant.destroy', { tenant: id }),
  selectable: route('api.selectable_tenants'),
};

/*
|--------------------------------------------------------------------------
| Unit
|--------------------------------------------------------------------------
*/
export const UNIT_ENDPOINTS = {
  index: route('api.unit.index'),
  store: route('api.unit.store'),
  show: (id) => route('api.unit.show', { unit: id }),
  update: (id) => route('api.unit.update', { unit: id }),
  destroy: (id) => route('api.unit.destroy', { unit: id }),
};

/*
|--------------------------------------------------------------------------
| User
|--------------------------------------------------------------------------
*/
export const USER_ENDPOINTS = {
  index: route('api.users.index'),
  store: route('api.users.store'),
  show: (id) => route('api.users.show', { user: id }),
  update: (id) => route('api.users.update', { user: id }),
  destroy: (id) => route('api.users.destroy', { user: id }),
  //reassign user roles
  updateUserRoles: (user_id) =>
    route('api.users.update-roles', { user: user_id }),

  roles: (user_id) => route('api.users.roles', { user: user_id }),
};


/*
|--------------------------------------------------------------------------
| Attribute and values
|--------------------------------------------------------------------------
*/
export const ATTRIBUTE_ENDPOINTS = {
  index: route('api.attribute.index'),
  store: route('api.attribute.store'),
  show: (id) => route('api.attribute.show', { attribute: id }),
  update: (id) => route('api.attribute.update', { attribute: id }),
  destroy: (id) => route('api.attribute.destroy', { attribute: id }),
};
