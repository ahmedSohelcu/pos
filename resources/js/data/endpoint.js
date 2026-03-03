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
  selectable: (type = 'common') =>
    route('selectable_statuses', { type }),
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
  show: (id) =>route('api.subscription.show', { subscription: id }),
  update: (id) =>route('api.subscription.update', { subscription: id }),
  destroy: (id) =>route('api.subscription.destroy', { subscription: id }),
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
};

/*
|--------------------------------------------------------------------------
| Feature
|--------------------------------------------------------------------------
*/
export const FEATURE_ENDPOINTS = {
  index: route('api.feature.index'),
  store: route('api.feature.store'),
  show: (id) => route('api.feature.show', { feature: id }),
  update: (id) => route('api.feature.update', { feature: id }),
  destroy: (id) => route('api.feature.destroy', { feature: id }),
};

/*
|--------------------------------------------------------------------------
| Role
|--------------------------------------------------------------------------
*/
export const ROLE_ENDPOINTS = {
  index: route('api.role.index'),
  store: route('api.role.store'),
  show: (id) => route('api.role.show', { role: id }),
  update: (id) => route('api.role.update', { role: id }),
  destroy: (id) => route('api.role.destroy', { role: id }),
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
  selectable: route('api.selectable-tenants'),
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
};