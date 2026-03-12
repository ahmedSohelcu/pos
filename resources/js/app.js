import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import router from './router';
import * as ahmedVueKit from './ahmed-vue-kit';
import Master from './admin/layouts/Mastere.vue';

import 'bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';

import $ from 'jquery';
window.$ = window.jQuery = $;

import select2 from 'select2/dist/js/select2.full.min.js';
import 'select2/dist/css/select2.min.css';

select2(window.$);

import { createI18n } from 'vue-i18n';
import en from './lang/en';
import bn from './lang/bn';

const i18n = createI18n({
  legacy: false,
  locale: 'en',
  fallbackLocale: 'en',
  messages: { en, bn },
});

const app = createApp(Master);
const pinia = createPinia();

app.use(pinia);
app.use(router);
app.use(i18n);

app.use(Toast, {
  position: 'top-right',
  timeout: 3000,
});

Object.entries(ahmedVueKit).forEach(([name, component]) => {
  app.component(name, component);
});

import { useAuthStore } from './ahmed-vue-kit/stores/authStore';

const auth = useAuthStore(pinia);

async function initAuth() {
  if (auth.token) {
    await auth.fetchMe(true);
  }
}

initAuth().finally(() => {
  app.mount('#app');
});

//===================================
//writer module
//===================================
// import Welcome from './components/Welcome.vue';

//==========================
//method 1
//==========================
// const app = createApp({
//     components: {
//         Welcome,
//     }
// });
// app.use(pinia)
// app.use(moment)
// app.mount("#app");

//==========================
//method 2
//==========================
// const app = createApp({})
// app.component('welcome', Welcome)
// app.component('assign-service-price', AssignServicePrice)
// app.mount('#app')
