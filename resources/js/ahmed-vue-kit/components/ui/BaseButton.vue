<script setup>
import { computed } from 'vue'

const props = defineProps({
  label: String,
  variant: {
    type: String,
    default: 'primary'
  },
  size: {
    type: String,
    default: 'md'
  },
  loading: Boolean,
  disabled: Boolean,
  full: Boolean,
  type: {
    type: String,
    default: 'button'
  },
  iconLeft: String,
  iconRight: String,
  as: {
    type: String,
    default: 'button' // button | a | router-link
  },
  href: String
})

const emit = defineEmits(['click'])

const classes = computed(() => [
  'base-btn',
  `btn-${props.variant}`,
  `btn-${props.size}`,
  props.full ? 'btn-full' : '',
  props.loading ? 'btn-loading' : ''
])

const handleClick = (e) => {
  if (!props.loading && !props.disabled) {
    emit('click', e)
  }
}
</script>

<template>
  <component
    :is="as"
    :href="as === 'a' ? href : null"
    :type="as === 'button' ? type : null"
    :class="classes"
    :disabled="disabled || loading"
    @click="handleClick"
  >
    <!-- Loading Spinner -->
    <span v-if="loading" class="spinner"></span>

    <!-- Left Icon -->
    <i v-if="iconLeft && !loading" :class="iconLeft" class="btn-icon left"></i>

    <span class="btn-label">
      <slot>{{ label }}</slot>
    </span>

    <!-- Right Icon -->
    <i v-if="iconRight && !loading" :class="iconRight" class="btn-icon right"></i>
  </component>
</template>

<style scoped>
.base-btn {
  border: none;
  border-radius: 10px;
  cursor: pointer;
  font-weight: 600;
  transition: all .25s ease;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  position: relative;
}

/* Sizes */
.btn-sm { padding: 6px 12px; font-size: 13px; }
.btn-md { padding: 10px 18px; font-size: 14px; }
.btn-lg { padding: 14px 24px; font-size: 16px; }

/* Full Width */
.btn-full {
  width: 100%;
}

/* Variants */
.btn-primary {
  background: linear-gradient(135deg, #4f46e5, #6366f1);
  color: white;
}

.btn-success {
  background: linear-gradient(135deg, #059669, #10b981);
  color: white;
}

.btn-danger {
  background: linear-gradient(135deg, #dc2626, #ef4444);
  color: white;
}

.btn-outline {
  background: transparent;
  border: 2px solid #4f46e5;
  color: #4f46e5;
}

.base-btn:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 6px 15px rgba(0,0,0,0.15);
}

.base-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* Loading */
.spinner {
  width: 16px;
  height: 16px;
  border: 2px solid white;
  border-top: 2px solid transparent;
  border-radius: 50%;
  animation: spin 0.7s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.btn-icon {
  font-size: 14px;
}
</style>



<!-- Button -->
<!--
    -----------------------    
    How To Use
    -----------------------
<h2>Base Button</h2> <hr>
<BaseButton 
  label="Submitting..."
  :loading="true"
/>

<BaseButton
  type="submit"
  :loading="false"
  iconLeft="fas fa-save"
>
  Save User
</BaseButton>

<BaseButton
    variant="danger"
    block
>
    Delete Account
</BaseButton>

<BaseButton
  label="Upload"
  iconLeft="fas fa-upload"
  variant="success"
/>

<BaseButton
  as="a"
  href="/users"
  label="Go to Users"
  variant="outline"
/>

<BaseButton
  label="Create Account"
  size="lg"
  full
/>
-->
<!-- Button -->