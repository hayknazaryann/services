import './bootstrap';

import { createApp } from 'vue';
import App from './views/client/layouts/App.vue'
const app = createApp(App);

// Routes
import router  from './router';
app.use(router);

// Vuetify
import vuetify  from './plugins/vuetify.js';
app.use(vuetify);

// Store
import store  from './store'
app.use(store);

// Vue toast
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
app.use(Toast, {
    position: "bottom-left",
    timeout: 5000,
    closeOnClick: false,
    pauseOnFocusLoss: true,
    pauseOnHover: false,
    draggable: true,
    draggablePercent: 0.6,
    showCloseButtonOnHover: true,
    hideProgressBar: false,
    icon: true,
    rtl: false
});

// Interceptor
import interceptorsSetup from './helpers/interceptors'
interceptorsSetup();

// Phone Input
import vPhoneInput from "./plugins/vPhoneInput.js";
app.use(vPhoneInput);

app.mount('#app');
