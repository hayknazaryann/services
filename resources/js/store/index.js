import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import settings from './modules/settings.js'
import auth from './modules/auth.js'

export default new createStore({
    plugins: [
        createPersistedState()
    ],
    modules: {
        settings,
        auth
    },
})
