import './bootstrap';

import { createApp } from 'vue'
import App from './views/client/layouts/App.vue'
const app = createApp(App);

// Routes
import router  from './router'
app.use(router);

// Vuetify
import vuetify  from './plugins/vuetify.js'
app.use(vuetify);

// Store
import store  from './store'
app.use(store);


app.mount('#app');
