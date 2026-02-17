<template>
  <form @submit.prevent="emitSubmit">
    <slot />
  </form>
</template>

<script setup>
  const emit = defineEmits(['submit'])

  const emitSubmit = () => {
    emit('submit')
  }
</script>



<!-- 
how to use
    <BaseForm @submit="saveUser">
        <BaseCard title="User Form" cardClass="col-md-6 card-outline card-info">
      <div class="mb-3">
        <input
          v-model="form.username"
          class="form-control"
          :class="{ 'is-invalid': errors.username }"
          placeholder="Username"
        />

        <div v-if="errors.username" class="invalid-feedback">
          {{ errors.username[0] }}
        </div>
      </div>

      <div class="mb-3">
        <input
          v-model="form.email"
          class="form-control"
          :class="{ 'is-invalid': errors.email }"
          placeholder="Email"
        />

        <div v-if="errors.email" class="invalid-feedback">
          {{ errors.email[0] }}
        </div>
      </div>
      </BaseCard>
  </BaseForm>

  <script setup>
    import { route } from 'ziggy-js';
    import { useForm } from '../../../../ahmed-vue-kit/composables/useForm';
  
    const { form, errors, submit, loading } = useForm({
      username: '',
      email: '',
      phone: ''
    })


      // Submit Form
      const saveUser = async () => {
        console.log(form)
        // await submit(route('selectable_statuses'), 'GET')
        alert('Saved successfully')
      }
</script>

-->