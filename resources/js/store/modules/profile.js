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
        user: state => state.user,
        token: state => state.token,
        isAuthenticated: state => state.isAuthenticated,
        isVerified: state => (state.user ? state.user.verified : false),
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
        async login({commit, dispatch}, data){
            try {
                await axios.get('/sanctum/csrf-cookie')
                const response = await axios.post('/api/client/login', data);
                dispatch('setUser');
                commit('SET_TOKEN', response.data.data.token);
            } catch (e) {
                throw e;
            }
        },

        async register({ dispatch, commit }, data) {
            try {
                await axios.get('/sanctum/csrf-cookie')
                const response = await axios.post('/api/client/register', data);
                toast.success(response.data.message);
                router.push({ path: '/login'});
            } catch (e) {
                throw e;
            }
        },

        async verifyEmail({commit}, data) {
            try {
                await axios.get('/sanctum/csrf-cookie')
                const response = await axios.post(`/api/client/verify-email/${data.id}/${data.hash}`);
                dispatch('setUser');
                toast.success(response.data.message);
            } catch (e) {
                throw e;
            }
        },

        async resendVerifyEmail({commit}, data) {
            try {
                await axios.get('/sanctum/csrf-cookie')
                const response = await axios.post('/api/client/verify-resend', data);
                toast.success(response.data.message);
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
                commit('SET_USER', null)
                commit('SET_AUTHENTICATED', false)
                commit('SET_TOKEN', null)
                router.push({ path: '/login'});
            } catch (e) {
                throw e;
            }
        },

        async forgotPassword({commit}, data) {
            try {
                await axios.get('/sanctum/csrf-cookie')
                const response = await axios.post('/api/client/password/forgot', data);
                toast.success(response.data.message);
            } catch (e) {
                throw e;
            }
        },

        async resetPassword({commit}, data) {
            try {
                await axios.get('/sanctum/csrf-cookie')
                const response = await axios.post('/api/client/password/reset', data);
                toast.success(response.data.message);
                router.push({ path: '/login'});
            } catch (e) {
                throw e;
            }
        },

        async updateProfile({ commit, dispatch }, data) {
            try {
                await axios.get('/sanctum/csrf-cookie')
                const response = await axios.post('/api/client/profile/update', data);
                dispatch('setUser');
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
