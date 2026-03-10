<template>
  <div
    class="login-wrapper d-flex justify-content-center align-items-center vh-100"
  >
    <div class="card p-4 shadow-sm" style="width: 400px">
      <h3 class="text-center mb-3">Sign In</h3>
      <form>
        <BaseInput
          v-model="form.email"
          label="Email"
          type="email"
          :error="form.errors.email"
          placeholder="Enter email"
          icon="fa-envelope"
        />

        <BaseInput
          v-model="form.password"
          label="Password"
          type="password"
          :error="form.errors.password"
          placeholder="Enter password"
          icon="fa-lock"
        />

        <button
          type="button"
          @click="login"
          class="btn btn-primary w-100"
          :disabled="auth.loading"
        >
          <span
            v-if="auth.loading"
            class="spinner-border spinner-border-sm me-1"
          ></span>
          Login
        </button>
      </form>
      <p class="text-center text-muted mt-3">
        Forgot your password? <a href="#" @click.prevent="reset">Reset</a>
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { useAuthStore } from '../../../ahmed-vue-kit/stores/authStore';
import { useRouter } from 'vue-router';
import { notify } from '@kit/composables/useNotify';
import { TENANT_ENDPOINTS } from '../../../data/endpoint';
const router = useRouter();

const auth = useAuthStore();

const form = reactive({
  email: '',
  password: '',
  errors: {},
});

const login = async () => {
  auth.loading = true;

  try {
    let res = await auth.login(form);

    console.log('res', res);

    notify.success(res?.data?.message || 'Logged In Successfully 2');
    router.push({ name: 'tenants.index' }); // ✅ redirect
  } catch (error) {
    form.errors = error.errors ?? {};
  } finally {
    auth.loading = false;
  }
};

const reset = () => {
  form.errors = {};
};
</script>

<style scoped>
.login-wrapper {
  background: #f1f3f5;
}
.card {
  border-radius: 10px;
}
</style>
