<script setup>
import { type } from 'jquery';
import { ref, onMounted, onBeforeUnmount, watch } from 'vue';

const props = defineProps({
  modelValue: Boolean,
  title: String,
  size: { type: String, default: 'md' }, // sm | md | lg | xl | fullscreen
  icon: { type: String, default: null },
  variant: { type: String, default: 'primary' }, // fallback for confirm
  confirmVariant: { type: String, default: null }, // confirm button variant
  cancelVariant: { type: String, default: 'light' }, // cancel button variant
  loading: { type: Boolean, default: false },
  confirmText: { type: String, default: 'Confirm' },
  cancelText: { type: String, default: 'Cancel' },
  centered: { type: Boolean, default: true },
  bodyClass: {
    type: String,
    default: '',
  },
});

const emit = defineEmits(['update:modelValue', 'confirm']);

const modalRef = ref(null);
let modalInstance = null;

onMounted(() => {
  const bootstrap = window.bootstrap;

  modalInstance = new bootstrap.Modal(modalRef.value, {
    backdrop: true, // allow outside click close
    keyboard: true, // allow ESC close
  });

  modalRef.value.addEventListener('hidden.bs.modal', () => {
    emit('update:modelValue', false); // keeps v-model in sync
    emit('close'); // ✅ custom close event
  });

  if (props.modelValue) modalInstance.show();
});

watch(
  () => props.modelValue,
  (val) => {
    if (!modalInstance) return;
    val ? modalInstance.show() : modalInstance.hide();
  }
);

onBeforeUnmount(() => {
  modalInstance?.dispose();
});

const close = () => modalInstance?.hide();

const confirm = () => {
  emit('confirm');
};
</script>

<template>
  <teleport to="body">
    <div class="modal fade custom-fade" ref="modalRef" tabindex="-1">
      <div
        class="modal-dialog"
        :class="[`modal-${size}`, { 'modal-dialog-centered': centered }]"
      >
        <div class="modal-content pro-modal">
          <!-- Header -->
          <div class="modal-header pro-header">
            <div class="d-flex align-items-center gap-2">
              <div
                v-if="icon"
                class="pro-icon"
                :class="`bg-${variant}-subtle text-${variant}`"
              >
                <i :class="icon"></i>
              </div>
              <h5 class="modal-title fw-semibold mb-0">
                {{ title }}
              </h5>
            </div>
            <button type="button" class="btn-close" @click="close"></button>
          </div>

          <!-- Body -->
          <div :class="bodyClass" class="modal-body pro-body">
            <slot />
          </div>

          <!-- Footer -->
          <div class="modal-footer pro-footer">
            <slot name="footer">
              <button
                class="btn px-4"
                :class="`btn-${cancelVariant}`"
                @click="close"
                :disabled="loading"
              >
                {{ cancelText }}
              </button>

              <button
                class="btn px-4"
                :class="`btn-${confirmVariant || variant}`"
                @click="confirm"
                :disabled="loading"
              >
                <span
                  v-if="loading"
                  class="spinner-border spinner-border-sm me-2"
                ></span>
                <!-- <i class="fa fa-save me-1"></i> -->
                {{ confirmText }}
              </button>
            </slot>
          </div>
        </div>
      </div>
    </div>
  </teleport>
</template>

<style scoped>
.custom-fade .modal-dialog {
  transition: transform 0.2s ease-out;
}

.pro-modal {
  border: none;
  border-radius: 14px;
  box-shadow: 0 15px 50px rgba(0, 0, 0, 0.08);
  overflow: hidden;
}

.pro-header {
  border-bottom: 1px solid #f1f1f1;
  padding: 18px 22px;
}

.pro-body {
  padding: 22px;
  font-size: 0.95rem;
}

.pro-footer {
  border-top: 1px solid #f1f1f1;
  padding: 16px 22px;
}

.pro-icon {
  width: 38px;
  height: 38px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 16px;
}
</style>
<!-- 
   ------------------
    How To Use
    ------------------

      //-------------------
      // Support
      //-------------------
      v-model="tenantStore.showModal"
      title="Delete Tenant"
      size="md" //sm | md | lg | xl | fullscreen|
      :loading="true" //will show spinner
      confirmText="Delete"
      cancelText="Cancel"
      confirmVariant="danger" //danger, secondary, outline-success etc
      cancelVariant="secondary" // danger, secondary, outline-success etc
      icon="fa-solid fa-plus"
      :centered="true"
      @confirm="deleteTenant"
      @close="closeModal" // function  trigger after modal close
      :bodyClass="'p-3 bg-light rounded-3 border h-100'"


        ---------------------------------
        //01. Basic Modal
        ---------------------------------
        <button class="btn btn-danger" @click="showModal = true">
          Show Modal
        </button> 
        <BaseModal
          v-model="showModal"
          title="Delete User"
          size="md" //sm | md | lg | xl | fullscreen| 
          @confirm="saveUser"
          variant="danger"
          @update:modelValue="closeModal"
          confirmText="Delete"
          cancelText="Cancel"

        >
          Are you sure you want to delete this user?
      </BaseModal>  
            
        //scripts
        import BaseModal from '@/kit/components/ui/BaseModal.vue';
        const showModal = ref(false)


        
      // to close modal
      //emit('update:modelValue', false);

-->
