import axios from 'axios';
import router from "../../router/index.js";
import Cookies from "js-cookie";

import {useToast} from "vue-toastification";
const toast = useToast();

export default {
    namespaced: true,
    state:{
        user: null,
        token: null,
        isAuthenticated: false,
    },
    getters:{
        user(state) {
            const birthdate = state.user ? state.user.birthdate: null;
            state.user.birthdate = birthdate ? new Date(birthdate) : null
            return state.user
        },
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
        RESET_STATE() {
            const s = this.initialState
            const state = this.state
            Object.keys(s).forEach(key => {
                state[key] = s[key]
            })
        },
    },
    actions:{
        async login({commit, dispatch}, userData){
            try {
                await axios.get('/sanctum/csrf-cookie')
                const response = await axios.post('/api/client/login', userData);
                dispatch('setUser');
                commit('SET_TOKEN', response.data.data.token);
            } catch (e) {
                throw e;
            }
        },

        async register({ dispatch, commit }, userData) {
            try {
                await axios.get('/sanctum/csrf-cookie')
                const response = await axios.post('/api/client/register', userData);
                toast.success(response.data.message);
                router.push({ path: '/login'});
            } catch (e) {
                throw e;
            }
        },

        async setUser({ commit }) {
            try {
                const response = await axios.get('/api/user');
                commit('SET_USER', response.data.data);
                commit('SET_AUTHENTICATED', true);
                router.push({ path: '/profile'});
            } catch (e) {
                throw e;
            }
        },

        async logout({commit}){
            try {
                await axios.get('/sanctum/csrf-cookie')
                const response = await axios.post('/api/client/logout');
                commit('SET_USER', {})
                commit('SET_AUTHENTICATED', false)
                commit('SET_TOKEN', null)
                router.push({ path: '/login'});
            } catch (e) {
                throw e;
            }
        },

        async updateProfile({ commit, dispatch }, userData) {
            try {
                await axios.get('/sanctum/csrf-cookie')
                const response = await axios.post('/api/client/profile/update', userData);
                commit('SET_USER', userData);
                toast.success(response.data.message);
            } catch (e) {
                throw e;
            }
        },

        async changePassword({commit}, data) {
            try {
                await axios.get('/sanctum/csrf-cookie')
                const response = await axios.post('/api/client/password/change', data);
                toast.success(response.data.message);
            } catch (e) {
                throw e;
            }
        }
    }
}
