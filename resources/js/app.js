import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import router from './router';
import * as ahmedVueKit from './ahmed-vue-kit';
import Master from './admin/layouts/Mastere.vue';


// important
import 'bootstrap'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'

//----------------------------------
// import vue toastification
//----------------------------------
import Toast from "vue-toastification"
import "vue-toastification/dist/index.css"


// ===============================
// jQuery + Select2 (CORRECT ORDER)
// ===============================
import $ from 'jquery';
window.$ = window.jQuery = $

import select2 from 'select2/dist/js/select2.full.min.js'
import 'select2/dist/css/select2.min.css'

// 🔥 FORCE ATTACH select2 to global jQuery
select2(window.$)
//----------------------------------------



const app = createApp(Master);

// Register all components globally
Object.entries(ahmedVueKit).forEach(([name, component]) => {
    app.component(name, component);
});

//02️⃣ Register all components locally
// const app = createApp({
//     components: {
//         Master,        
//     },
// });

// use vue-toastification
app.use(Toast, {
    position: "top-right",
    timeout: 3000,
    closeOnClick: true,
    pauseOnHover: true,
})

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



