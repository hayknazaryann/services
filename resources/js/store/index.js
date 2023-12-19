import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import example from './modules/example.js'
import settings from './modules/settings.js'

export default new createStore({
    plugins: [
        createPersistedState()
    ],
    modules: {
        settings
    },
})
