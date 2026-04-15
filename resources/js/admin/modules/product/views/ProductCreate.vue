<script setup>
import { reactive, computed } from 'vue';
import BaseForm from '../../../../ahmed-vue-kit/components/form/BaseForm.vue';

const form = reactive({
  name: '',
  slug: '',
  product_type: 'single',

  brand_id: '',
  category_id: '',
  unit_id: '',

  sku: '',
  barcode: '',
  cost_price: '',
  selling_price: '',
  stock: '',

  track_stock: true,
  alert_quantity: '',

  description: '',

  thumbnail: null,
  gallery: [],

  status_id: 1,
  sorting_order: 0,

  attributes: [],
  variants: [],
});

const isSingle = computed(() => form.product_type === 'single');
const isVariant = computed(() => form.product_type === 'variant');
const isService = computed(() => form.product_type === 'service');

function addAttribute() {
  form.attributes.push({ name: '', values: '' });
}

function removeAttribute(i) {
  form.attributes.splice(i, 1);
}

function generateVariants() {
  const attrs = form.attributes
    .filter((a) => a.values)
    .map((a) => a.values.split(',').map((v) => v.trim()));

  if (!attrs.length) return;

  const combinations = attrs.reduce((a, b) =>
    a.flatMap((d) => b.map((e) => [].concat(d, e)))
  );

  form.variants = combinations.map((c) => ({
    name: c.join('-'),
    sku: generateSKU(),
    barcode: generateBarcode(),
    cost_price: '',
    sale_price: '',
    stock: '',
    thumbnail: null,
  }));
}

function generateSKU() {
  return 'SKU-' + Math.random().toString(36).substring(2, 8).toUpperCase();
}

function generateBarcode() {
  return Math.floor(100000000000 + Math.random() * 900000000000);
}

function removeVariant(i) {
  form.variants.splice(i, 1);
}

function handleThumbnail(e) {
  form.thumbnail = URL.createObjectURL(e.target.files[0]);
}

function handleGallery(e) {
  const files = Array.from(e.target.files);
  files.forEach((f) => form.gallery.push(URL.createObjectURL(f)));
}

function handleVariantImage(e, variant) {
  variant.thumbnail = URL.createObjectURL(e.target.files[0]);
}

function cancel() {
  window.history.back();
}

function saveProduct() {
  console.log('submit', form);
}
</script>

<template>
  <div class="product-page">
    <!-- HEADER -->
    <div class="page-header">
      <div>
        <h2>Create Product</h2>
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
              <div class="col-md-6">
                <label>Product Name</label>
                <input v-model="form.name" class="form-control input-modern" />
              </div>

              <div class="col-md-6">
                <label>Slug</label>
                <input v-model="form.slug" class="form-control input-modern" />
              </div>

              <div class="col-md-4">
                <label>Product Type</label>
                <select
                  v-model="form.product_type"
                  class="form-select input-modern"
                >
                  <option value="single">Single</option>
                  <option value="variant">Variant</option>
                  <option value="service">Service</option>
                </select>
              </div>

              <div class="col-md-4">
                <label>Brand</label>
                <select
                  v-model="form.brand_id"
                  class="form-select input-modern"
                ></select>
              </div>

              <div class="col-md-4">
                <label>Category</label>
                <select
                  v-model="form.category_id"
                  class="form-select input-modern"
                ></select>
              </div>

              <div class="col-md-4" v-if="!isService">
                <label>Unit</label>
                <select
                  v-model="form.unit_id"
                  class="form-select input-modern"
                ></select>
              </div>
            </div>
          </div>
        </div>

        <!-- MEDIA -->
        <div class="card card card-outline card-primary mt-4">
          <div class="card-header">Product Media</div>
          <div class="card-body">
            <div class="row g-4">
              <div class="col-md-4">
                <label>Thumbnail</label>
                <div class="upload-box">
                  <input type="file" @change="handleThumbnail" />
                  <img v-if="form.thumbnail" :src="form.thumbnail" />
                </div>
              </div>

              <div class="col-md-8">
                <label>Gallery</label>
                <input
                  type="file"
                  multiple
                  @change="handleGallery"
                  class="form-control mb-3"
                />
                <div class="gallery-grid">
                  <img v-for="(img, i) in form.gallery" :key="i" :src="img" />
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- PRICING -->
        <div v-if="isSingle" class="card card-outline card-primary mt-4">
          <div class="card-header">Pricing & Inventory</div>
          <div class="card-body">
            <div class="row g-4">
              <div class="col-md-3">
                <label>SKU</label>
                <input v-model="form.sku" class="form-control" />
              </div>

              <div class="col-md-3">
                <label>Barcode</label>
                <input v-model="form.barcode" class="form-control" />
              </div>

              <div class="col-md-2">
                <label>Cost</label>
                <input
                  type="number"
                  v-model="form.cost_price"
                  class="form-control"
                />
              </div>

              <div class="col-md-2">
                <label>Sale Price</label>
                <input
                  type="number"
                  v-model="form.selling_price"
                  class="form-control"
                />
              </div>

              <div class="col-md-2">
                <label>Stock</label>
                <input
                  type="number"
                  v-model="form.stock"
                  class="form-control"
                />
              </div>
            </div>
          </div>
        </div>

        <!-- VARIANTS -->
        <div v-if="isVariant" class="card card-outline card-primary mt-4 mb-4">
          <div class="card-header d-flex justify-content-between">
            <span>Attributes</span>
            <button
              class="btn btn-outline-primary btn-sm"
              @click="addAttribute"
            >
              Add Attribute
            </button>
          </div>

          <div class="card-body">
            <div
              v-for="(attr, index) in form.attributes"
              :key="index"
              class="row g-3 mb-3"
            >
              <div class="col-md-4">
                <input
                  v-model="attr.name"
                  placeholder="Color"
                  class="form-control"
                />
              </div>
              <div class="col-md-6">
                <input
                  v-model="attr.values"
                  placeholder="Red, Blue, Green"
                  class="form-control"
                />
              </div>
              <div class="col-md-2">
                <button
                  class="btn btn-danger w-100"
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
                  <th>Image</th>
                  <th>Variant</th>
                  <th>SKU</th>
                  <th>Price</th>
                  <th>Stock</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(variant, i) in form.variants" :key="i">
                  <td>
                    <input
                      type="file"
                      @change="(e) => handleVariantImage(e, variant)"
                    />
                    <img
                      v-if="variant.thumbnail"
                      :src="variant.thumbnail"
                      class="variant-img"
                    />
                  </td>
                  <td>{{ variant.name }}</td>
                  <td><input v-model="variant.sku" class="form-control" /></td>
                  <td>
                    <input
                      type="number"
                      v-model="variant.sale_price"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <input
                      type="number"
                      v-model="variant.stock"
                      class="form-control"
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
      </div>

      <!-- SIDEBAR -->
      <div class="col-lg-3">
        <div class="sticky-panel">
          <div class="card card-outline card-primary">
            <div class="card-header">Product Settings</div>
            <div class="card-body">
              <label>Status</label>
              <select v-model="form.status_id" class="form-select mb-3">
                <option value="1">Active</option>
                <option value="2">Inactive</option>
              </select>

              <label>Sorting</label>
              <input
                type="number"
                v-model="form.sorting_order"
                class="form-control"
              />
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ACTION BUTTONS -->
    <div class="action-bar">
      <button class="btn btn-light cancel-btn" @click="cancel">Cancel</button>
      <button class="btn btn-primary save-btn" @click="saveProduct">
        Save Product
      </button>
    </div>
  </div>
</template>

<style scoped>
.product-page {
  padding: 30px;
  padding-bottom: 140px;
  background: #eef2f7; /* professional subtle gray-blue */
}

.section-card {
  border: none;
  border-radius: 12px;
  box-shadow: 0 6px 25px rgba(0, 0, 0, 0.07);
  background: #ffffff; /* white card background */
}

.section-card .card-header {
  font-weight: 600;
  background: #ffffff;
  border-bottom: 1px solid #ddd;
}

.card-body {
  padding: 25px;
}

.input-modern:focus {
  border-color: #4f46e5;
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
}

.upload-box {
  border: 2px dashed #cfd8e3;
  padding: 35px;
  text-align: center;
  border-radius: 10px;
  background: #f9fafc;
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
  background: #f3f4f8;
}

.action-bar {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  background: #ffffff;
  border-top: 1px solid #ddd;
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
  background: #f1f3f6;
  border: none;
}
</style>
