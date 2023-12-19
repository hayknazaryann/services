export default {
    namespaced: true,
    state:{
        darkMode: false
    },
    getters:{
        darkMode(state) {
            return state.darkMode;
        },
    },
    mutations:{
        SWITCH_DARK(state) {
            state.darkMode = !state.darkMode
        },
    },
    actions:{
        async changeTheme({ commit }) {
            commit('SWITCH_DARK')
        },
    }
}
