/*************  ✨ Windsurf Command 🌟  *************/
/**
 * Recursively builds a FormData object from a given object.
 * 
 * The function takes three parameters:
 * - `data`: The object to be converted into a FormData object.
 * - `parentKey`: The parent key of the current object in the recursion.
 * - `formData`: The FormData object to be populated.

 * The function returns the populated FormData object.
 */
/*************  Build FormData Utility (UPDATED) *************/

export const buildFormData = (
  data,
  parentKey = '',
  formData = new FormData()
) => {
  if (data === null || data === undefined) return formData;

  Object.entries(data).forEach(([key, value]) => {
    const fullKey = parentKey ? `${parentKey}[${key}]` : key;

    // =========================
    // FILE (single file)
    // =========================
    if (value instanceof File) {
      formData.append(fullKey, value);
    }

    // =========================
    // ARRAY
    // =========================
    else if (Array.isArray(value)) {
      if (value.length === 0) return;

      value.forEach((item, index) => {
        const arrayKey = `${fullKey}[]`;

        // FILE inside array
        if (item instanceof File) {
          formData.append(arrayKey, item);
        }

        // OBJECT inside array
        else if (typeof item === 'object' && item !== null) {
          buildFormData(item, `${fullKey}[${index}]`, formData);
        }

        // BOOLEAN inside array
        else if (typeof item === 'boolean') {
          formData.append(arrayKey, item ? 1 : 0);
        }

        // PRIMITIVE inside array
        else {
          formData.append(arrayKey, item);
        }
      });
    }

    // =========================
    // OBJECT (nested object)
    // =========================
    else if (typeof value === 'object' && value !== null) {
      buildFormData(value, fullKey, formData);
    }

    // =========================
    // BOOLEAN (IMPORTANT FIX)
    // =========================
    else if (typeof value === 'boolean') {
      formData.append(fullKey, value ? 1 : 0);
    }

    // =========================
    // PRIMITIVE
    // =========================
    else {
      formData.append(fullKey, value ?? '');
    }
  });

  return formData;
};

// How to User
/* <script setup>
import axios from 'axios'
import { buildFormData } from '@/utils/buildFormData'
import { ref } from 'vue'

const form = ref({
    username: '',
    email: '',
    fruits: [1,2,3],
    description: 'Hello Description here',
    images: []
})

const loading = ref(false)
const errors = ref({})

const submit = async () => {

    loading.value = true
    errors.value = {}

    try {

        const formData = buildFormData(form.value)

        await axios.post('/api/users', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })

        alert('Saved Successfully')

    } catch (error) {

        if (error.response?.status === 422) {
            errors.value = error.response.data.errors
        }

    } finally {
        loading.value = false
    }
}
</script> */
