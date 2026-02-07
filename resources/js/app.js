import './bootstrap';

import { createApp } from 'vue';
import { createPinia } from 'pinia';
import router from './router';

import * as ahmedVueKit from  './ahmed-vue-kit';
import Master from './admin/layouts/Mastere.vue';

const app = createApp(Master);

// 1️⃣ Register all components globally
Object.entries(ahmedVueKit).forEach(([name, component]) => {
    app.component(name, component);
});

//02️⃣ Register all components locally
// const app = createApp({
//     components: {
//         Master,        
//     },
// });

app.use(createPinia());
app.use(router);
app.mount('#app');





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



