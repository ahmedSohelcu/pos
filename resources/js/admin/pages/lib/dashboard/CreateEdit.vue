<template>      
  <BaseForm @submit="saveUser">
        <BaseCard title="User Form" cardClass="col-md-6 card-outline card-info">                  

          <!-- select2 not working -->
          <BaseSelect
            name="category_id"
            :options="categories"
            label="Category"
            select2
            multiple
            placeholder="Select category"
        />
          <BaseSelect
            v-model="form.category"
            name="category_id"
            :options="categories"
            label="Category"   
            select2    
            placeholder="Select category"
          /> 

          <BaseInput 
            v-model="form.datetime"
            label="datetime"
            :error="errors.datetime"
            :type="'datetime'"
            placeholder="datetime"
          />

          <BaseInput 
            v-model="form.username" 
            label="Username"
            :error="errors.username"
            placeholder="username here"
          />

          <BaseInput 
            v-model="form.email" 
            label="Email"
            placeholder="username here"
          />

        
      </BaseCard>
  </BaseForm>
</template>

<script setup>

  import { route } from 'ziggy-js';
  import { useForm } from '../../../../ahmed-vue-kit/composables/useForm';  

  const { form, errors, submit, loading } = useForm({
    username: '',
    email: '',
    phone: '',
    time: '',
    status_id: 1,
    states: [],
    category: [],
  })

  const categories = [
    { id: 1, name: 'Abc'},
    { id: 2, name: 'EFG'},
    { id: 3, name: 'tes'},
  ]

  // Submit Form
  const saveUser = async () => {
    console.log(form)
    // await submit(route('selectable_statuses'), 'GET')
    alert('Saved successfully')
  }
</script>
