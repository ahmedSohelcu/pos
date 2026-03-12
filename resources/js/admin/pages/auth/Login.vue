<template>
  <div class="login-wrapper d-flex justify-content-center align-items-center vh-100">
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
          <span v-if="auth.loading" class="spinner-border spinner-border-sm me-1"></span>
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
import { reactive } from "vue";
import { useAuthStore } from "../../../ahmed-vue-kit/stores/authStore";
import { useRouter } from "vue-router";
import { notify } from "@kit/composables/useNotify";

const auth = useAuthStore();
const router = useRouter();

const form = reactive({ email: "", password: "", errors: {} });

const login = async () => {
  auth.loading = true;

  try {
    const res = await auth.login(form);
    notify.success(res?.data?.message || "Logged In Successfully");

    router.push({ name: "dashboard" });
    // if (auth.subscriptionExpired) {
    //   router.push({ name: 'SubscriptionExpired' });
    // } else {
    //   router.push({ name: 'dashboard' });
    // }
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
