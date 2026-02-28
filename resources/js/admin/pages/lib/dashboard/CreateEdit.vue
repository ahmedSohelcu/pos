<template>
  <div class="col-md-6 offset-md-1">
    <BaseCard>
      <BaseForm @submit="saveUser">
        <h2>Example BaseShimmer</h2>
        <div v-if="loading">
          <BaseShimmer width="100%" height="200px" rounded />
          <BaseShimmer width="60%" height="20px" className="mt-3" />
          <BaseShimmer width="80%" height="14px" className="mt-2" />
          <BaseShimmer width="90%" height="14px" className="mt-2" />
        </div>

        <div v-else>
          <div class="real-content">
            <img :src="post.image" class="w-full h-52 object-cover rounded" />
            <h3 class="font-bold text-lg mt-3">{{ post.title }}</h3>
            <p class="text-gray-700 mt-2">{{ post.body }}</p>
          </div>
        </div>

        <br />

        <br />

        <BaseRichTextEditor
          v-model="form.description"
          label="Quill Editor Description"
          :read-only="readOnly"
          :error="errors.description"
          :placeholder="'hello placeholder'"
        />
        <br /><br />

        <!-- Button -->
        <h2>Base Button</h2>
        <hr />
        <BaseButton label="Submitting..." :loading="true" />

        <BaseButton type="submit" :loading="false" iconLeft="fas fa-save">
          Save User
        </BaseButton>

        <BaseButton variant="danger" block> Delete Account </BaseButton>

        <BaseButton label="Upload" iconLeft="fas fa-upload" variant="success" />

        <BaseButton
          as="a"
          href="/users"
          label="Go to Users"
          variant="outline"
        />

        <BaseButton label="Create Account" size="lg" full />

        <!-- Button -->
        <br /><br />
        <h2>BaseFileUpload</h2>
        <BaseFileUpload
          v-model="form.images"
          label="Product Images"
          :required="true"
          :multiple="false"
          :existing-files="existingImages"
          delete-url="/product/image/delete"
          :max-size="5000"
        />

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

        <BaseShimmer width="100%" height="200px" rounded />
        <BaseShimmer width="60%" height="20px" className="mt-3" />
        <BaseShimmer width="90%" height="14px" className="mt-2" />
        <BaseShimmer width="80%" height="14px" className="mt-2" />

        <br />
      </BaseForm>
    </BaseCard>
  </div>
</template>

<script setup>
import { useForm } from '@kit/composables/useForm';
import BaseRichTextEditor from '@kit/components/form/BaseRichTextEditor.vue';

import { useNotify } from '@/ahmed-vue-kit/composables/useNotify';
import BaseFileUpload from '@kit/components/form/BaseFileUpload.vue';
import BaseShimmer from '@kit/components/ui/BaseShimmer.vue';
import { onMounted, reactive } from 'vue';

const toast = useNotify();
toast.success('Success Message');

const { ref, form, errors, submit, loading } = useForm({
  username: '',
  email: '',
  phone: '',
  time: '',
  status_id: 1,
  states: [],
  category: [],
  gender: 1,
  fruits: [1, 2, 3],
  description: 'Hello Description here',
  images: [],
});

loading.value = true;
const post = reactive({ title: '', body: '', image: '' });

onMounted(() => {
  setTimeout(() => {
    post.title = 'Hello World';
    post.body = 'This is the content loaded from backend';
    post.image = 'https://picsum.photos/600/300';
    loading.value = false;
  }, 2000);
});

const onClick = () => alert('Badge clicked!');

const genders = [
  { id: 1, gender: 'Male' },
  { id: 2, gender: 'Female' },
  { id: 3, gender: 'Others' },
];

const fruits = [
  { id: 1, name: 'Banana' },
  { id: 2, name: 'Jack Fruits' },
  { id: 3, name: 'Pine Apple' },
];

const categories = [
  { id: 1, name: 'Abc' },
  { id: 2, name: 'EFG' },
  { id: 3, name: 'tes' },
];

const existingImages = [
  { id: 1, url: 'https://placehold.co/600x400/png' },
  { id: 2, url: 'https://placehold.co/600x400/png' },
];

// Submit Form
const saveUser = async () => {
  console.log(form);
  // await submit(route('selectable_statuses'), 'GET')
  alert('Saved successfully');
};
</script>
