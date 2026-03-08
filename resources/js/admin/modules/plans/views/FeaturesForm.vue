<template>
  <div class="permission-card p-3">
    <!-- Select All Toggle -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <strong class="h5 mb-0">Plan Features</strong>
        <small class="text-muted ms-2">for: {{ planName ?? '' }}</small>
      </div>

      <div class="form-check form-switch">
        <input
          type="checkbox"
          class="form-check-input"
          id="selectAllFeatures"
          :checked="allFeaturesSelected"
          @change="toggleAllFeatures"
        />
        <label class="form-check-label" for="selectAllFeatures">
          Select All
        </label>
      </div>
    </div>

    <div class="accordion" id="featuresAccordion">
      <template v-for="(module, index) in features" :key="module.module">
        <div class="accordion-item mb-3 shadow-sm rounded">
          <!-- Module Header -->
          <h2 class="accordion-header" :id="'heading' + index">
            <button
              class="accordion-button collapsed d-flex justify-content-between align-items-center"
              type="button"
              data-bs-toggle="collapse"
              :data-bs-target="'#collapse' + index"
              aria-expanded="false"
              :aria-controls="'collapse' + index"
            >
              <div>
                <i class="fas fa-layer-group text-primary me-2"></i>
                <strong>{{ module.module }}</strong>
                <span
                  class="badge ms-2"
                  :class="moduleBadgeClass(module)"
                >
                  {{ enabledCount(module) }}/{{ module.features.length }}
                </span>
              </div>

              <div class="form-check form-switch ms-3">
                <input
                  type="checkbox"
                  class="form-check-input"
                  :checked="isModuleSelected(module)"
                  @change.stop="toggleModule(module)"
                />
              </div>
            </button>
          </h2>

          <!-- Feature Items -->
          <div
            :id="'collapse' + index"
            class="accordion-collapse collapse"
            :aria-labelledby="'heading' + index"
            data-bs-parent="#featuresAccordion"
          >
            <div class="accordion-body row g-2">
              <div
                class="col-md-6 col-sm-12"
                v-for="feature in module.features"
                :key="feature.id"
              >
                <div
                  class="d-flex justify-content-between align-items-center border rounded p-2 feature-item"
                  :title="feature.description"
                >
                  <div>
                    {{ formatFeatureName(feature.name) }}
                    <span
                      class="badge ms-2"
                      :class="selectedFeaturesArray.includes(feature.id)
                        ? 'bg-success'
                        : 'bg-secondary'"
                    >
                      {{ selectedFeaturesArray.includes(feature.id) ? 'Enabled' : 'Disabled' }}
                    </span>
                  </div>

                  <div class="form-check form-switch">
                    <input
                      type="checkbox"
                      class="form-check-input"
                      :value="feature.id"
                      :checked="selectedFeaturesArray.includes(feature.id)"
                      @change.stop="toggleFeature(feature.id)"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  features: { type: Array, default: () => [] },
  modelValue: { type: Array, default: () => [] },
  planName: { type: String, default: '' },
})

const emit = defineEmits(['update:modelValue'])

const selectedFeaturesArray = computed({
  get: () => (Array.isArray(props.modelValue) ? props.modelValue : []),
  set: (val) => emit('update:modelValue', [...new Set(val)]),
})

// Format feature name: user.create -> Create User
const formatFeatureName = (name) => {
  return name
    .split('.')
    .reverse()
    .join(' ')
    .replace(/\b\w/g, (l) => l.toUpperCase())
}

// Toggle individual feature
const toggleFeature = (id) => {
  const val = selectedFeaturesArray.value
  selectedFeaturesArray.value = val.includes(id)
    ? val.filter((f) => f !== id)
    : [...val, id]
}

// Module toggle
const isModuleSelected = (module) => {
  const val = selectedFeaturesArray.value
  return module.features.every((f) => val.includes(f.id))
}

const toggleModule = (module) => {
  const val = selectedFeaturesArray.value
  const ids = module.features.map((f) => f.id)
  const allSelected = ids.every((id) => val.includes(id))
  selectedFeaturesArray.value = allSelected
    ? val.filter((f) => !ids.includes(f))
    : [...new Set([...val, ...ids])]
}

// Select All Features
const allFeaturesSelected = computed(() => {
  const val = selectedFeaturesArray.value
  const allIds = props.features.flatMap((m) => m.features.map((f) => f.id))
  return allIds.length && allIds.every((id) => val.includes(id))
})

const toggleAllFeatures = () => {
  const val = selectedFeaturesArray.value
  const allIds = props.features.flatMap((m) => m.features.map((f) => f.id))
  selectedFeaturesArray.value = allFeaturesSelected.value
    ? []
    : [...new Set([...val, ...allIds])]
}

// Module badge color: green if all enabled, warning if partially enabled, gray if none
const moduleBadgeClass = (module) => {
  const enabled = enabledCount(module)
  if (enabled === 0) return 'bg-secondary'
  if (enabled === module.features.length) return 'bg-success'
  return 'bg-warning text-dark'
}

// Count enabled features in module
const enabledCount = (module) => {
  return module.features.filter((f) => selectedFeaturesArray.value.includes(f.id))
    .length
}
</script>

<style scoped>
.permission-card {
  border-radius: 12px;
  background: #fff;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
}

.accordion-button {
  background-color: #f8fafc;
  transition: 0.2s;
  font-weight: 500;
}
.accordion-button:hover {
  background-color: #e6f0fb;
}

.feature-item {
  transition: 0.2s;
  cursor: pointer;
}
.feature-item:hover {
  background: #f3f6fb;
}

.badge {
  font-size: 0.75rem;
  font-weight: 500;
}
</style>