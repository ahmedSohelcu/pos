import { ref } from 'vue';
import api from '../api/api';
import { buildFormData } from '@/utils/buildFormData';

export function useFormSubmit() {
  const loading = ref(false);
  const errors = ref({});

  /**
   * 🔥 Universal Save (Create / Update)
   */
  const submit = async ({
    url,
    data,
    id = null,
    multipart = true,
    method = null,
  }) => {
    loading.value = true;
    errors.value = {};

    try {
      let finalUrl = url;
      let payload = data;
      let httpMethod = method || 'post';

      // 👉 UPDATE mode
      if (id) {
        finalUrl = `${url}/${id}`;
        payload = {
          ...data,
          _method: 'PUT', // Laravel support
        };
      }

      // 👉 Convert to FormData if needed
      if (multipart) {
        payload = buildFormData(payload);
      }

      const res = await api({
        url: finalUrl,
        method: httpMethod,
        data: payload,
        headers: multipart ? { 'Content-Type': 'multipart/form-data' } : {},
      });

      return res.data;
    } catch (error) {
      errors.value = error.response?.data?.errors || {};
      throw error;
    } finally {
      loading.value = false;
    }
  };

  return {
    submit,
    loading,
    errors,
  };
}
