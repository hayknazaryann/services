import axios from 'axios';
import Cookies from "js-cookie";
import router from "../../router/index.js";
export default {
    namespaced: true,
    state:{
        user: null,
        token: null,
        isAuthenticated: false,
    },
    getters:{
        user: state => state.user,
        token: state => state.token,
        isAuthenticated: state => state.isAuthenticated,
    },
    mutations:{
        SET_USER(state, user) {
            state.user = user;
        },
        SET_TOKEN(state, token) {
            state.token = token;
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        },
        SET_AUTHENTICATED(state, isAuthenticated) {
            state.isAuthenticated = isAuthenticated;
        },
    },
    actions:{
        async login({commit, dispatch}, userData){
            try {
                await axios.get('/sanctum/csrf-cookie')
                const response = await axios.post('/api/client/login', userData);
                dispatch('setUser');
                commit('SET_TOKEN', response.data.data.token);
            } catch (error) {
                console.error(error);
            }
        },
        async register({ dispatch, commit }, userData) {
            try {
                await axios.get('/sanctum/csrf-cookie')
                const response = await axios.post('/api/client/register', userData);
                dispatch('setUser');
                commit('SET_TOKEN', response.data.data.token);
            } catch (error) {
                console.error(error);
            }
        },
        async setUser({ commit }) {
            try {
                const response = await axios.get('/api/user');
                commit('SET_USER', response.data);
                commit('SET_AUTHENTICATED', true);
            } catch (error) {
                console.error(error);
            }
        },

        async logout({commit}){
            try {
                await axios.get('/sanctum/csrf-cookie')
                const response = await axios.post('/api/client/logout');
                commit('SET_USER', {})
                commit('SET_AUTHENTICATED', false)
                commit('SET_TOKEN', null)
            } catch (error) {
                console.error(error);
            }

        }
    }
}
