import './bootstrap';

import { createApp } from 'vue'
import App from './views/layouts/App.vue'

// Router
import router  from './router'

// Vuetify
import vuetify  from './plugins/vuetify.js'

createApp(App)
    .use(vuetify)
    .use(router)
    .mount("#app")
