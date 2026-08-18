<template>
  <div class="expired-wrapper">
    <div class="expired-card">
      <!-- Icon -->
      <div class="icon">
        <i class="bi bi-shield-exclamation"></i>
      </div>

      <!-- Title -->
      <h1 class="title">Subscription Expired</h1>
      <!-- {{ formatDate(auth.subscription?.starts_at) }} - -->
      On {{ formatDateDayYear(auth.subscription?.ends_at) }}
      <p class="subtitle">
        Your subscription plan has expired. To continue using the system, please
        renew or upgrade your plan.
      </p>

      <!-- Plan Info -->
      <div class="plan-info" v-if="auth.subscription">
        <div class="info-row">
          <span>Current Plan</span>
          <strong>{{ auth.subscription.plan_name || 'N/A' }}</strong>
        </div>

        <div class="info-row" v-if="auth.subscription?.expired_at">
          <span>Expired On</span>
          <strong>{{ formatDate(auth.subscription.expired_at) }}</strong>
        </div>
      </div>

      <!-- Actions -->
      <div class="actions">
        <router-link
          v-if="auth.hasAccess('subscription.renew')"
          :to="{ name: 'subscriptions.index' }"
          class="btn-primary"
        >
          Renew Subscription
        </router-link>

        <button class="btn-outline" @click="logout">Logout</button>
      </div>

      <!-- Divider -->
      <div class="divider"></div>

      <!-- Support -->
      <div class="support">
        <h3>Need Help?</h3>

        <p>
          If you believe this is a mistake or need assistance renewing your
          subscription, please contact our support team.
        </p>

        <div class="contact-info">
          <div class="contact-item">
            <i class="bi bi-envelope"></i>
            <span>support@example.com</span>
          </div>

          <div class="contact-item">
            <i class="bi bi-telephone"></i>
            <span>+880 1700 000000</span>
          </div>

          <div class="contact-item">
            <i class="bi bi-whatsapp"></i>
            <span>WhatsApp: +880 1700 000000</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useAuthStore } from '../../ahmed-vue-kit/stores/authStore';
import { useRouter } from 'vue-router';
import { formatDateDayYear } from '../../ahmed-vue-kit/utils/helpers';

const auth = useAuthStore();
const router = useRouter();

const logout = async () => {
  await auth.logout();
  router.push({ name: 'Login' });
};

const formatDate = (date) => {
  return new Date(date).toLocaleDateString();
};
</script>

<style scoped>
.expired-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background: var(--app-bg);
  padding: 20px;
}

.expired-card {
  width: 480px;
  max-width: 100%;
  background: var(--app-surface);
  padding: 40px;
  border-radius: 14px;
  text-align: center;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
}

.icon {
  font-size: 55px;
  color: #ef4444;
  margin-bottom: 15px;
}

.title {
  font-size: 26px;
  font-weight: 700;
  margin-bottom: 8px;
}

.subtitle {
  color: var(--app-text-muted);
  font-size: 14px;
  margin-bottom: 25px;
}

.plan-info {
  background: var(--app-surface-muted);
  border-radius: 10px;
  padding: 15px;
  margin-bottom: 25px;
}

.info-row {
  display: flex;
  justify-content: space-between;
  margin: 6px 0;
  font-size: 14px;
}

.actions {
  display: flex;
  justify-content: center;
  gap: 12px;
  margin-bottom: 25px;
}

.btn-primary {
  background: #4f46e5;
  color: white;
  padding: 10px 18px;
  border-radius: 6px;
  text-decoration: none;
  font-weight: 500;
  transition: 0.2s;
}

.btn-primary:hover {
  background: #4338ca;
}

.btn-outline {
  border: 1px solid var(--app-border);
  padding: 10px 18px;
  border-radius: 6px;
  background: var(--app-surface);
  cursor: pointer;
}

.divider {
  height: 1px;
  background: var(--app-border);
  margin: 20px 0;
}

.support {
  text-align: center;
}

.support h3 {
  font-size: 16px;
  margin-bottom: 6px;
}

.support p {
  font-size: 13px;
  color: var(--app-text-muted);
  margin-bottom: 12px;
}

.contact-info {
  display: flex;
  flex-direction: column;
  gap: 6px;
  font-size: 14px;
}

.contact-item {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  color: var(--app-text);
}

.contact-item i {
  color: #4f46e5;
}
</style>
