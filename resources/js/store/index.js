import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import settings from './modules/settings.js'
import profile from './modules/profile.js'



const initialState = {
    profile: profile.state,
}

const store = new createStore({
    plugins: [
        createPersistedState(),
    ],
    modules: {
        settings,
        profile
    },
    actions: {
        resetAllModules({ commit, state }) {
            Object.keys(initialState).forEach((moduleNamespace) => {
                const resetMutation = `${moduleNamespace}/RESET_STATE`;
                commit(resetMutation);
            });
        },
    },
});

store.initialState = initialState;

export default store
