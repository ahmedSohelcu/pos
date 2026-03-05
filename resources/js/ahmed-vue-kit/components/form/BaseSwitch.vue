<template>
  <div class="d-flex flex-column gap-1">
    <div class="d-flex align-items-center justify-content-between gap-3">
      <!-- Label Section -->
      <div v-if="label">
        <label class="fw-semibold mb-1 d-block">
          {{ label }}
        </label>
        <small v-if="description" class="text-muted">
          {{ description }}
        </small>
      </div>

      <!-- Switch -->
      <label class="base-switch" :class="sizeClass">
        <input
          type="checkbox"
          :checked="modelValue"
          :disabled="disabled"
          @change="$emit('update:modelValue', $event.target.checked)"
        />
        <span class="slider" :style="sliderStyle">
          <span class="switch-text">
            {{ modelValue ? activeText : inactiveText }}
          </span>
        </span>
      </label>
    </div>

    <!-- Validation Error -->
    <div v-if="error" class="text-danger small">
      {{ error }}
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  modelValue: {
    type: Boolean,
    default: false,
  },
  label: String,
  description: String,
  disabled: Boolean,
  activeText: {
    type: String,
    default: 'ON',
  },
  inactiveText: {
    type: String,
    default: 'OFF',
  },
  size: {
    type: String,
    default: 'md', // sm | md | lg
  },
  activeColor: {
    type: String,
    default: '#198754', // green
  },
  inactiveColor: {
    type: String,
    default: '#dc3545', // red
  },
  error: {
    type: String,
    default: '', // new prop for error
  },
});

defineEmits(['update:modelValue']);

const sizeClass = computed(() => ({
  'switch-sm': props.size === 'sm',
  'switch-md': props.size === 'md',
  'switch-lg': props.size === 'lg',
}));

const sliderStyle = computed(() => ({
  background: props.modelValue ? props.activeColor : props.inactiveColor,
}));
</script>

<style scoped>
.base-switch {
  position: relative;
  display: inline-block;
}

.base-switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* ===== Sizes ===== */
.switch-sm {
  width: 60px;
  height: 30px;
}
.switch-md {
  width: 90px;
  height: 44px;
}
.switch-lg {
  width: 120px;
  height: 55px;
}

/* ===== Slider ===== */
.base-switch .slider {
  position: absolute;
  inset: 0;
  cursor: pointer;
  border-radius: 50px;
  transition: 0.3s;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 600;
  color: #fff;
  font-size: 13px;
}

/* Circle */
.base-switch .slider::before {
  content: '';
  position: absolute;
  background: white;
  border-radius: 50%;
  transition: 0.3s;
}

/* Circle Sizes */
.switch-sm .slider::before {
  height: 22px;
  width: 22px;
  left: 4px;
  bottom: 4px;
}
.switch-md .slider::before {
  height: 34px;
  width: 34px;
  left: 5px;
  bottom: 5px;
}
.switch-lg .slider::before {
  height: 44px;
  width: 44px;
  left: 6px;
  bottom: 6px;
}

/* Move Animation */
.switch-sm input:checked + .slider::before {
  transform: translateX(30px);
}
.switch-md input:checked + .slider::before {
  transform: translateX(46px);
}
.switch-lg input:checked + .slider::before {
  transform: translateX(60px);
}

.base-switch input:disabled + .slider {
  opacity: 0.6;
  cursor: not-allowed;
}
</style>

<!-- How to use
// <BaseSwitch
//     v-model="model.is_current"
//     size="md"
//     :class="'p-3 bg-light rounded-3 border h-100'"
//     activeColor="#198754"
//     inactiveColor="#dc3545"
//     activeText="ACTIVE"
//     inactiveText="INACTIVE"
//     label="Current Subscription"
//     :error="errors.is_current"
//     description="Mark this subscription as active"
// /> 
-->
