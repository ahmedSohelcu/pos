import { ref } from 'vue'

export function useForm(initialData = {}) {
  const form = ref({ ...initialData })
  const errors = ref({})
  const loading = ref(false)

  const submit = async (url, method = 'POST') => {
    loading.value = true
    errors.value = {}

    try {
      const formData = new FormData()

      for (const key in form.value) {
        formData.append(key, form.value[key])
      }

      if (!['GET', 'POST'].includes(method)) {
        formData.append('_method', method)
      }

      const response = await fetch(url, {
        method: 'POST',
        body: formData
      })

      const data = await response.json()

      if (!response.ok) {
        errors.value = data.errors || {}
        throw data
      }

      return data
    } finally {
      loading.value = false
    }
  }

  return { form, errors, loading, submit }
}
