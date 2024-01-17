import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import settings from './modules/settings.js'
import profile from './modules/profile.js'
import notes from "./modules/notes.js";



const initialState = {
    profile: profile.state,
}

const store = new createStore({
    plugins: [
        createPersistedState(),
    ],
    modules: {
        settings,
        profile,
        notes
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
