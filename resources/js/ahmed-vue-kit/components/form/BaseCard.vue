<template>
  <div :class="['card', cardClass]">
    <!-- Header -->
    <div v-if="title || $slots.header" class="card-header">
      <h3 class="card-title">
        <slot name="header">{{ title }}</slot>
      </h3>
    </div>

    <!-- Body -->
    <div class="card-body">
      <slot>
        {{ body }}
      </slot>
    </div>

    <!-- Footer -->
    <div class="card-footer d-flex justify-content-between align-items-center">
      
      <!-- Left Buttons -->
      <div>
        <slot name="footer-left">
          <button
            v-for="(btn, index) in leftFooterButtons"
            :key="'left-' + index"
            :type="btn.type || 'button'"
            :class="['btn', `btn-${btn.bg || 'primary'}`, btn.class || 'me-2']"
            @click="btn.onClick"
          >
            {{ btn.text }}
          </button>
        </slot>
      </div>

      <!-- Right Buttons or Default Submit -->
      <div class="ms-auto d-flex align-items-center">
        <slot name="footer-right">
          <button
            v-for="(btn, index) in rightFooterButtons"
            :key="'right-' + index"
            :type="btn.type || 'button'"
            :class="['btn', `btn-${btn.bg || 'success'}`, btn.class || 'ms-2']"
            @click="btn.onClick"
          >
            {{ btn.text }}
          </button>

          <!-- Default submit button if rightFooterButtons empty -->
            <button
                v-if="!leftFooterButtons.length && !rightFooterButtons.length && !$slots['footer-left'] && !$slots['footer-right']"
                type="submit"
                class="btn btn-success"
                >
                Submit
            </button>
        </slot>
      </div>

    </div>

  </div>
</template>

<script setup>
    const props = defineProps({
        title: { type: String, default: '' },
        cardClass: { type: String, default: 'card-outline card-primary mb-4' },
        // Footer
        footerText: { type: String, default: '' },
        leftFooterButtons: { type: Array, default: () => [] },
        rightFooterButtons: { type: Array, default: () => [] },
    })
</script>

<style scoped>
    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
</style>

<!--How to use

        //----------------------------
        // Manage left and right footer buttons
        //----------------------------
      <BaseCard
            title="Form Actions"
            :leftFooterButtons="[{ text: 'Cancel', variant: 'secondary', onClick: handleCancel }]"
            :rightFooterButtons="[{ text: 'Save', variant: 'success', type: 'submit', onClick: handleSave }]">

            body....
            <input type="text" class="form-control" placeholder="Username">

        </BaseCard>


        //----------------------------
        // handle default submit
        //----------------------------
        <form @submit.prevent="handleSubmit">
            <BaseCard title="User Form" cardClass="col-md-6 card-outline card-success mb-4">
                <div>
                    <input type="text" v-model="username" placeholder="Username" class="form-control mb-2">
                    <input type="email" v-model="email" placeholder="Email" class="form-control mb-2">
                    <input type="email" v-model="email" placeholder="Email" class="form-control mb-2">
                </div>
                
            </BaseCard>
      </form>  

    const handleSubmit = (e) => {
        alert('Submit');
    }

    ** can add button in footer left or right or both
      **it not button is pass then default submit button will show which will
        control by form @submit.prevent top wraper of this basecard component


    -->