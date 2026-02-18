<script setup>
    import { ref, onMounted, onBeforeUnmount, watch } from "vue"
    import { Modal } from "bootstrap"

    const props = defineProps({
        modelValue: {
            type: Boolean,
            default: false
        },
        title: {
            type: String,
            default: "Modal Title"
        },
        size: {
            type: String,
            default: "md" // sm | md | lg | xl
        }
    })

    const emit = defineEmits(["update:modelValue", "confirm"])

    const modalRef = ref(null)
    let modalInstance = null

    onMounted(() => {
        modalInstance = new Modal(modalRef.value)

        modalRef.value.addEventListener("hidden.bs.modal", () => {
            emit("update:modelValue", false)
        })
    })

    watch(() => props.modelValue, (val) => {
        if (val) {
            modalInstance.show()
        } else {
            modalInstance.hide()
        }
    })

    const close = () => {
        modalInstance.hide()
    }

    const confirm = () => {
        emit("confirm")
        modalInstance.hide()
    }
</script>

<template>
  <div class="modal fade" ref="modalRef" tabindex="-1">
    <div class="modal-dialog" :class="`modal-${size}`">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">{{ title }}</h5>
          <button type="button" class="btn-close" @click="close"></button>
        </div>

        <div class="modal-body">
          <slot />
        </div>

        <div class="modal-footer">
          <slot name="footer">
            <button class="btn btn-secondary" @click="close">
              Cancel
            </button>
            <button class="btn btn-primary" @click="confirm">
              Confirm
            </button>
          </slot>
        </div>

      </div>
    </div>
  </div>
</template>



<!-- 
   ------------------
    How To Use
    ------------------
        ---------------------------------
        //01. Basic Modal
        ---------------------------------
        <button class="btn btn-danger" @click="showModal = true">
          Show Modal
        </button>

        <BaseModal
          v-model="showModal"
          title="Delete User"
          size="md"
          @confirm="deleteUser"
        >
          Are you sure you want to delete this user?
      </BaseModal>

        //scripts
        import BaseModal from '../../../../ahmed-vue-kit/components/ui/BaseModal.vue';
        const showModal = ref(false)



        ---------------------------------
        //02.  Modal Component with form
        ---------------------------------
        // modal start
        <button class="btn btn-danger" @click="showModal = true">
          Show Modal
        </button>

       <BaseModal v-model="showModal" title="Create User" size="lg">  
        <form @submit.prevent="saveUser">
          <input class="form-control mb-2" v-model="form.name" placeholder="Name">
          <input class="form-control" v-model="form.email" placeholder="Email">
        </form>

        <template #footer>
          <button class="btn btn-secondary" @click="showModal = false">
            Cancel
          </button>

          <button class="btn btn-success" @click="saveUser">
            Save
          </button>
        </template>
    </BaseModal>

    ---------------
    // scripts
    ---------------
    import BaseModal from '../../../../ahmed-vue-kit/components/ui/BaseModal.vue';
    const showModal = ref(false)

-->