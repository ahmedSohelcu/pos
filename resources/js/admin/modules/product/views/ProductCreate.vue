<script setup>
import { reactive, computed, onMounted, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import BaseInput from '../../../../ahmed-vue-kit/components/form/BaseInput.vue';
import {
  BRAND_ENDPOINTS,
  CATEGORY_ENDPOINTS,
  UNIT_ENDPOINTS,
  PRODUCT_ENDPOINTS,
  ATTRIBUTE_ENDPOINTS,
} from '../../../../data/endpoint';

import BaseFileUpload from '../../../../ahmed-vue-kit/components/form/BaseFileUpload.vue';

import { useProductStore } from '../store';
import { useAuthStore } from '../../../../ahmed-vue-kit/stores/authStore';
import BaseRichTextEditor from '../../../../ahmed-vue-kit/components/form/BaseRichTextEditor.vue';
import api from '../../../../ahmed-vue-kit/api/api';
import { notify } from '@kit/composables/useNotify';

const productStore = useProductStore();
const auth = useAuthStore();
const route = useRoute();
const router = useRouter();

const isEdit = computed(() => route.name === 'product.edit');

const form = reactive({
  id: null,
  name: '',
  slug: '',
  product_type: 'single',
  tenant_id: auth.tenant_id || null,

  brand_id: '',
  category_id: '',
  unit_id: '',

  sku: '',
  barcode: '',
  purchase_price: '',
  sale_price: '',
  stock: '',
  track_stock: true,
  alert_quantity: '',
  description: '',

  product_thumbnail: null,
  product_galleries: [],

  existingThumbnail: [],
  existingGalleries: [],

  is_active: true,
  sorting_order: 0,

  attributes: [
    {
      uid: Date.now(),
      attribute_id: '',
      selectable_values: [],
      values: [],
    },
  ],

  variants: [],
});

const errors = computed(() => productStore.errors);

const firstError = (prefix) => {
  const key = Object.keys(productStore.errors ?? {}).find((k) =>
    k.startsWith(prefix)
  );
  return key ? productStore.errors[key] : null;
};

const variantError = (index, field) =>
  productStore.errors?.[`variants.${index}.${field}`];

const attributeErrors = computed(() =>
  Object.keys(productStore.errors ?? {}).filter((k) => k.includes('.attributes.'))
);

const isSingle = computed(() => form.product_type === 'single');
const isVariant = computed(() => form.product_type === 'variant');
const isService = computed(() => form.product_type === 'service');

function addAttribute() {
  form.attributes.push({
    uid: Date.now() + Math.random(),
    attribute_id: '',
    selectable_values: [],
    values: [],
  });
}

function removeAttribute(i) {
  form.attributes.splice(i, 1);
}

async function loadAttributeValues(attr) {
  if (!attr.attribute_id) {
    attr.selectable_values = [];
    return;
  }

  try {
    const res = await api.get(
      ATTRIBUTE_ENDPOINTS.attributeValues(attr.attribute_id)
    );
    attr.selectable_values = res.data;
  } catch (err) {
    console.error(err);
  }
}

/**
 * Reset values when attribute changes
 */
function onAttributeChange(index) {
  const currentAttributeId = form.attributes[index].attribute_id;

  // prevent duplicate attribute selection
  const alreadyExists = form.attributes.some(
    (attr, i) =>
      i !== index && String(attr.attribute_id) === String(currentAttributeId)
  );

  if (alreadyExists) {
    alert('This attribute is already selected');

    form.attributes[index].attribute_id = '';
    form.attributes[index].values = [];
    form.attributes[index].selectable_values = [];

    return;
  }

  // reset values
  form.attributes[index].values = [];
  form.attributes[index].selectable_values = [];

  loadAttributeValues(form.attributes[index]);
}

function generateVariants() {
  const attrs = form.attributes
    .filter((a) => Array.isArray(a.values) && a.values.length)
    .map((a) =>
      a.values.map((valueId) => {
        const found = a.selectable_values.find(
          (item) => String(item.id) === String(valueId)
        );

        return {
          attribute_id: a.attribute_id,
          attribute_value_id: valueId,
          value_name: found ? found.value : valueId,
        };
      })
    );

  if (!attrs.length) return;

  // handle single attribute (no reduce needed)
  const combinations =
    attrs.length === 1
      ? attrs[0].map((item) => [item])
      : attrs.reduce((a, b) =>
          a.flatMap((d) => b.map((e) => [].concat(d, e)))
        );

  form.variants = combinations.map((combination) => ({
    name: combination.map((item) => item.value_name).join('-'),

    attributes: combination.map((item) => ({
      attribute_id: item.attribute_id,
      attribute_value_id: item.attribute_value_id,
    })),

    sku: generateSKU(),
    purchase_price: '',
    sale_price: '',
    stock: '',
    variant_thumbnail: null,
  }));
}

function generateSKU() {
  return 'SKU-' + Math.random().toString(36).substring(2, 8).toUpperCase();
}

function removeVariant(i) {
  form.variants.splice(i, 1);
}

function cancel() {
  window.history.back();
}

function onThumbnailDeleted() {
  form.existingThumbnail = [];
  form.product_thumbnail = null;
}

function onGalleryDeleted(file) {
  form.existingGalleries = form.existingGalleries.filter(
    (f) => f.id !== file.id
  );
}

const intOnly = (val) => {
  if (val === null || val === undefined || val === '') return '';

  const n = Math.trunc(Number(val));
  return Number.isNaN(n) ? '' : Math.max(0, n);
};

function normalizeIntegers() {
  form.stock = intOnly(form.stock);
  form.alert_quantity = intOnly(form.alert_quantity);

  form.variants.forEach((v) => {
    v.stock = intOnly(v.stock);
  });
}

// reset attributes/variants when leaving variant type
watch(
  () => form.product_type,
  (val) => {
    if (val !== 'variant') {
      form.variants = [];
      form.attributes = [
        {
          uid: Date.now(),
          attribute_id: '',
          selectable_values: [],
          values: [],
        },
      ];
    }
  }
);

//------------------------------------------
// EDIT MODE
//------------------------------------------
async function loadProduct() {
  try {
    const product = await productStore.show(PRODUCT_ENDPOINTS.show(form.id));

    form.name = product.name ?? '';
    form.slug = product.slug ?? '';
    form.product_type = product.product_type ?? 'single';
    form.brand_id = product.brand_id ?? '';
    form.category_id = product.category_id ?? '';
    form.unit_id = product.unit_id ?? '';
    form.sku = product.sku ?? '';
    form.barcode = product.barcode ?? '';
    form.purchase_price = product.purchase_price ?? '';
    form.sale_price = product.sale_price ?? '';
    form.stock = product.stock ?? '';
    form.track_stock = product.track_stock ?? true;
    form.alert_quantity = product.alert_quantity ?? '';
    form.description = product.description ?? '';
    form.is_active = product.is_active ?? true;
    form.sorting_order = product.sorting_order ?? 0;

    // existing media
    form.existingThumbnail = product.thumbnail
      ? [{ id: 0, url: product.thumbnail }]
      : [];

    form.existingGalleries = (product.media ?? [])
      .filter((m) => m.collection === 'gallery')
      .map((m) => ({ id: m.id, url: m.url }));

    // variants
    if (product.product_type === 'variant' && product.variants?.length) {
      const attrMap = new Map();

      product.variants.forEach((v) => {
        (v.attributes ?? []).forEach((a) => {
          if (!attrMap.has(String(a.attribute_id))) {
            attrMap.set(String(a.attribute_id), new Set());
          }
          attrMap.get(String(a.attribute_id)).add(String(a.attribute_value_id));
        });
      });

      form.attributes = [...attrMap.entries()].map(
        ([attribute_id, values], index) => ({
          uid: Date.now() + index,
          attribute_id,
          selectable_values: [],
          values: [...values],
        })
      );

      form.attributes.forEach((attr) => loadAttributeValues(attr));

      form.variants = product.variants.map((v) => ({
        id: v.id,
        name: v.name ?? '',
        attributes: (v.attributes ?? []).map((a) => ({
          attribute_id: a.attribute_id,
          attribute_value_id: a.attribute_value_id,
        })),
        sku: v.sku ?? '',
        purchase_price: v.purchase_price ?? '',
        sale_price: v.sale_price ?? '',
        stock: v.stock ?? '',
        variant_thumbnail: null,
      }));
    }
  } catch (error) {
    notify.error('Failed to load product.');
  }
}

onMounted(() => {
  if (isEdit.value) {
    form.id = route.params.id;
    productStore.mode = 'edit';
    loadProduct();
  } else {
    productStore.mode = 'create';
  }
});

const createOrUpate = async () => {
  productStore.errors = {};

  normalizeIntegers();

  let success;

  if (isEdit.value) {
    success = await productStore.update(PRODUCT_ENDPOINTS.update(form.id), form);
  } else {
    success = await productStore.create(PRODUCT_ENDPOINTS.store, form);
  }

  if (success) {
    router.push({ name: 'product.index' });
  }
};
</script>


<template>
  <div class="product-page">
    <!-- HEADER -->
    <div class="page-header">
      <div>
        <h2>{{ isEdit ? 'Edit Product' : 'Add New Product' }}</h2>
        <p>Manage your store inventory efficiently</p>
      </div>
    </div>

    <div class="row g-4">
      <!-- MAIN -->
      <div class="col-lg-9">
        <!-- BASIC -->
        <div class="card card-outline card-primary mb-4">
          <div class="card-header">Basic Information</div>

          <div class="card-body">
            <div class="row g-4">
              <div class="col-md-8">
                <BaseInput
                  name="name"
                  label="Product Name"
                  v-model="form.name"
                  :error="errors?.name"
                  placeholder="Enter Product Name"
                />
              </div>

              <div class="col-md-4">
                <BaseSelect
                  class="me-2"
                  v-model="form.product_type"
                  name="product_type"
                  :options="[
                    { id: 'single', label: 'Single' },
                    { id: 'variant', label: 'Variant' },
                    { id: 'service', label: 'Service' },
                  ]"
                  label="Product Type"
                  select2
                  optionKeyName="label"
                  placeholder="Choose Product Type"
                  :error="errors?.product_type"
                />
              </div>

              <div class="col">
                <BaseSelect
                  class="me-2"
                  v-model="form.category_id"
                  name="category_id"
                  :getApiRoute="CATEGORY_ENDPOINTS.selectable"
                  label="Category"
                  select2
                  placeholder="Choose Category"
                  :error="errors?.category_id"
                />

                <div class="me-2">{{ form.category_id }}</div>
              </div>

              <div class="col">
                <BaseSelect
                  class="me-2"
                  v-model="form.brand_id"
                  name="brand_id"
                  :getApiRoute="BRAND_ENDPOINTS.selectable"
                  label="Brand"
                  select2
                  placeholder="Choose Brand"
                  :error="errors?.brand_id"
                />

                <div class="me-2">{{ form.brand_id }}</div>
              </div>

              <div class="col" v-if="!isService">
                <BaseSelect
                  class="me-2"
                  v-model="form.unit_id"
                  name="unit_id"
                  :getApiRoute="UNIT_ENDPOINTS.selectable"
                  label="Unit"
                  select2
                  placeholder="Unit"
                  :error="errors?.unit_id"
                />

                <div class="me-2">{{ form.unit_id }}</div>
              </div>
            </div>
          </div>
        </div>

        <!-- MEDIA -->
        <div class="card card-outline card-primary mt-4">
          <div class="card-header">Product Media</div>

          <div class="card-body">
            <div class="row g-4">
              <div class="col-md-4">
                <BaseFileUpload
                  label="Thumbnail"
                  v-model="form.product_thumbnail"
                  :existingFiles="form.existingThumbnail"
                  :multiple="false"
                  :deleteUrl="isEdit ? PRODUCT_ENDPOINTS.deleteThumbnail(form.id) : null"
                  @deleted="onThumbnailDeleted"
                  :maxSize="1024"
                  class="border border-1 p-3 border-gray-300 rounded-2"
                />
                <small
                  v-if="errors?.product_thumbnail"
                  class="text-danger d-block mt-1"
                  >{{ errors.product_thumbnail[0] }}</small
                >
              </div>

              <div class="col-md-8">
                <BaseFileUpload
                  label="Gallery Images"
                  v-model="form.product_galleries"
                  :existingFiles="form.existingGalleries"
                  :multiple="true"
                  :deleteUrl="isEdit ? PRODUCT_ENDPOINTS.deleteGallery(form.id) : null"
                  @deleted="onGalleryDeleted"
                  :maxSize="1024"
                  class="border border-1 p-3 border-gray-300 rounded-2"
                />
                <small
                  v-if="firstError('product_galleries')"
                  class="text-danger d-block mt-1"
                  >{{ firstError('product_galleries')[0] }}</small
                >
              </div>
            </div>
          </div>
        </div>

        <!-- PRICING -->
        <div v-if="isSingle" class="card card-outline card-primary mt-4">
          <div class="card-header">Pricing & Inventory</div>

          <div class="card-body">
            <div class="row g-4">
              <div class="col">
                <BaseInput
                  v-model="form.sku"
                  label="SKU"
                  type="text"
                  :error="errors.sku"
                  placeholder="Enter sku"
                  icon="fa-store"
                />
              </div>

              <div class="col">
                <BaseInput
                  v-model="form.purchase_price"
                  label="Purchase Price"
                  type="number"
                  :error="errors.purchase_price"
                  placeholder="Enter purchase price"
                  icon="fa-store"
                />
              </div>

              <div class="col">
                <BaseInput
                  v-model="form.sale_price"
                  label="Sell Price"
                  type="number"
                  :error="errors.sale_price"
                  placeholder="Enter Sell price"
                  icon="fa-store"
                />
              </div>

              <div class="col">
                <BaseInput
                  type="number"
                  min="0"
                  step="1"
                  :model-value="form.stock"
                  @update:modelValue="v => form.stock = intOnly(v)"
                  label="Stock"
                  :error="errors.stock"
                  placeholder="Enter Stock"
                  icon="fa-store"
                />
              </div>

              <div class="col">
                <BaseInput
                  type="number"
                  min="0"
                  step="1"
                  :model-value="form.alert_quantity"
                  @update:modelValue="v => form.alert_quantity = intOnly(v)"
                  label="Stock Alert"
                  :error="errors.alert_quantity"
                  placeholder="Enter stock alert"
                  icon="fa-store"
                />
              </div>
            </div>
          </div>
        </div>

        <!-- VARIANTS -->
        <div v-if="isVariant" class="card card-outline card-primary mt-4 mb-4">
          <div class="card-header d-flex align-items-center">
            <span>Attributes</span>

            <button
              class="btn btn-outline-primary btn-sm ms-auto"
              type="button"
              @click="addAttribute"
            >
              Add More Attribute
            </button>
          </div>

          <div class="card-body">
            <div
              v-if="attributeErrors.length"
              class="alert alert-danger py-2 mb-3"
            >
              <div v-for="key in attributeErrors" :key="key">
                {{ productStore.errors[key][0] }}
              </div>
            </div>

            <div
              v-for="(attr, index) in form.attributes"
              :key="attr.uid"
              class="row g-3 mb-3"
            >
              <!-- {{ form.attributes[index] }} -->

              <!-- ATTRIBUTE -->
              <div class="col">
                <BaseSelect
                  :getApiRoute="ATTRIBUTE_ENDPOINTS.selectable"
                  select2
                  v-model="form.attributes[index].attribute_id"
                  placeholder="Choose an Attribute"
                  @update:modelValue="onAttributeChange(index)"
                />
              </div>

              <!-- ATTRIBUTE VALUES -->
              <div class="col">
                <BaseSelect
                  select2
                  placeholder="Choose Attribute Values"
                  :options="form.attributes[index].selectable_values"
                  v-model="form.attributes[index].values"
                  :optionKeyName="'value'"
                  multiple
                />
              </div>

              <div class="col">
                <button
                  class="btn btn-danger w-100"
                  type="button"
                  @click="removeAttribute(index)"
                >
                  Remove
                </button>
              </div>
            </div>

            <button class="btn btn-primary mb-4" @click="generateVariants">
              Generate Variants
            </button>

            <table v-if="form.variants.length" class="table table-modern">
              <thead>
                <tr>
                  <th>Variant Thumbnail</th>
                  <th>Variant</th>
                  <th>SKU</th>
                  <th>Purchase Price</th>
                  <th>Selling Price</th>
                  <th>Stock</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                <tr v-for="(variant, i) in form.variants" :key="i">
                  <td>
                    <BaseFileUpload
                      v-model="variant.variant_thumbnail"
                      :multiple="false"
                      :maxSize="1024"
                    />
                    <small
                      v-if="variantError(i, 'variant_thumbnail')"
                      class="text-danger d-block mt-1"
                      >{{ variantError(i, 'variant_thumbnail')[0] }}</small
                    >
                  </td>

                  <td>
                    {{ variant.name }}
                    <small
                      v-if="variantError(i, 'name')"
                      class="text-danger d-block"
                      >{{ variantError(i, 'name')[0] }}</small
                    >
                  </td>

                  <td>
                    <BaseInput
                      v-model="variant.sku"
                      :error="variantError(i, 'sku')"
                    />
                  </td>

                  <td>
                    <BaseInput
                      type="number"
                      v-model="variant.purchase_price"
                      :error="variantError(i, 'purchase_price')"
                    />
                  </td>

                  <td>
                    <BaseInput
                      type="number"
                      v-model="variant.sale_price"
                      :error="variantError(i, 'sale_price')"
                    />
                  </td>

                  <td>
                    <BaseInput
                      type="number"
                      min="0"
                      step="1"
                      :model-value="variant.stock"
                      @update:modelValue="v => variant.stock = intOnly(v)"
                      :error="variantError(i, 'stock')"
                    />
                  </td>

                  <td>
                    <button
                      class="btn btn-danger btn-sm"
                      @click="removeVariant(i)"
                    >
                      ✕
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- DESCRIPTION -->
        <div class="card card-outline card-primary mt-4">
          <div class="card-header">Description</div>

          <div class="card-body">
            <BaseRichTextEditor v-model="form.description" />
          </div>
        </div>
      </div>

      <!-- SIDEBAR -->
      <div class="col-lg-3">
        <div class="sticky-panel">
          <div class="card card-outline card-primary">
            <div class="card-header">Product Settings</div>

            <div class="card-body">
              <BaseSwitch
                v-model="form.is_active"
                size="md"
                name="is_active"
                activeColor="#198754"
                inactiveColor="#dc3545"
                activeText="ACTIVE"
                inactiveText="INACTIVE"
                label="Product Status"
                :error="errors.is_active"
                description="Mark this product as active or inactive"
              />

              <BaseSwitch
                v-model="form.track_stock"
                size="md"
                class="mb-2"
                name="track_stock"
                activeColor="#198754"
                inactiveColor="#dc3545"
                activeText="ACTIVE"
                inactiveText="INACTIVE"
                label="track Product Stock"
                :error="errors.track_stock"
                description="Mark this product as active or inactive"
              />

              <hr />

              <BaseInput
                name="sorting_order"
                type="number"
                v-model="form.sorting_order"
                label="Sorting"
                :error="errors?.sorting_order"
              />
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ACTION BUTTONS -->
    <div class="action-bar">
      <button class="btn btn-light cancel-btn" @click="cancel">Cancel</button>

      <button class="btn btn-primary save-btn" @click="createOrUpate">
        Save Product
      </button>
    </div>
  </div>
</template>

<style scoped>
.product-page {
  padding: 30px;
  padding-bottom: 140px;
  background: var(--app-bg);
}

.section-card {
  border: none;
  border-radius: 12px;
  box-shadow: 0 6px 25px rgba(0, 0, 0, 0.07);
  background: var(--app-surface);
}

.section-card .card-header {
  font-weight: 600;
  background: var(--app-surface);
  border-bottom: 1px solid var(--app-border);
}

.card-body {
  padding: 25px;
}

.input-modern:focus {
  border-color: #4f46e5;
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
}

.upload-box {
  border: 2px dashed var(--app-border);
  padding: 35px;
  text-align: center;
  border-radius: 10px;
  background: var(--app-surface-muted);
}

.upload-box img {
  width: 100%;
  margin-top: 10px;
  border-radius: 8px;
}

.gallery-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 10px;
}

.gallery-grid img {
  width: 100%;
  height: 90px;
  object-fit: cover;
  border-radius: 6px;
}

.variant-img {
  width: 40px;
  margin-top: 6px;
}

.sticky-panel {
  position: sticky;
  top: 20px;
}

.table-modern thead {
  background: var(--app-surface-muted);
}

.action-bar {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  background: var(--app-surface);
  border-top: 1px solid var(--app-border);
  padding: 15px 30px;
  display: flex;
  justify-content: flex-end;
  gap: 15px;
  box-shadow: 0 -6px 25px rgba(0, 0, 0, 0.07);
}

.save-btn {
  background: linear-gradient(135deg, #4f46e5, #6366f1);
  border: none;
  padding: 10px 22px;
  font-weight: 600;
  color: white;
  transition:
    transform 0.2s ease,
    box-shadow 0.2s ease;
}

.save-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
}

.cancel-btn {
  padding: 10px 22px;
  background: var(--app-surface-muted);
  border: none;
}
</style>
