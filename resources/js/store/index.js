import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import settings from './modules/settings.js'
import profile from './modules/profile.js'

export default new createStore({
    plugins: [
        createPersistedState()
    ],
    modules: {
        settings,
        profile
    },
})
