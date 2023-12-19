import './bootstrap';

import { createApp } from 'vue'
import App from './views/client/layouts/App.vue'

// Router
import router  from './router'

// Vuetify
import vuetify  from './plugins/vuetify.js'

// Store
import store  from './store'

createApp(App)
    .use(vuetify)
    .use(router)
    .use(store)
    .mount("#app")
