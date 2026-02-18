<template>      
  <BaseForm @submit="saveUser">
        <BaseCard title="User Form" cardClass="col-md-6 card-outline card-info">                  



<br>

    <BaseRichTextEditor
      v-model="form.description"
      label="Quill Editor Description"
      :read-only="readOnly"
      :error="errors.description"
      :placeholder="'hello placeholder'"
    /> 
    <br><br>


        <BaseTextarea
          v-model="form.description"
          name="description"
          label="Description"
          placeholder="Enter a description here..."
          :rows="5"
          :error="errors.description"
        />         

        <BaseCheckbox
          v-model="form.fruits"
          name="fruits"
          label="Fruit List"
          :options="fruits"
          :error="errors.fruits"
          inline
        />

        <BaseRadio
          v-model="form.gender"
          name="gender"
          label="Gender"
          :options="genders"
          :error="male"
          :inline="true"
          labelKey="gender"
        />

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
  import { useForm } from "../../../../ahmed-vue-kit/composables/useForm";  
  import BaseRichTextEditor from "../../../../ahmed-vue-kit/components/form/BaseRichTextEditor.vue";

  import  { useNotify }  from "@/ahmed-vue-kit/composables/useNotify";
  const toast = useNotify();
  toast.success("Success Message");


  const { form, errors, submit, loading } = useForm({
    username: '',
    email: '',
    phone: '',
    time: '',
    status_id: 1,
    states: [],
    category: [],
    gender: 1,
    fruits: [1, 2,3],
    description: "Hello Description here",
    
  });

  const genders = [
      { id: 1, gender: 'Male'},
      { id: 2, gender: 'Female'},
      { id: 3, gender: 'Others'},
  ]

  const fruits = [
    { id: 1, name: 'Banana'},
    { id: 2, name: 'Jack Fruits'},
    { id: 3, name: 'Pine Apple'},
  ]

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
