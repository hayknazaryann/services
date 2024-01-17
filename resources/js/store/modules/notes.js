import axios from "axios";
import {useToast} from "vue-toastification";
const toast = useToast();
export default {
    namespaced: true,
    state:{
        notes: [],
        note: null
    },
    getters:{
        getNotes(state) {
            return state.notes;
        },
        getNote(state) {
            return state.note;
        },
    },
    mutations:{
        SET_NOTES(state, notes) {
            state.notes = notes;
        },
        SET_NOTE(state,note) {
            state.note = note;
        },
        SET_CREATED_NOTE(state, note) {
            state.notes.unshift(note);
            state.notes.pop();
        },
        SET_UPDATED_NOTE(state, updatedNote) {
            Object.assign(state.notes.filter(note  => note.id === updatedNote.id)[0], updatedNote)
        },
        DELETE_NOTE(state, noteId) {
            state.notes.splice(state.notes.findIndex(note => note.id === noteId),1);
        },
        SET_CURRENT_PAGE(state, currentPage) {
            state.currentPage = currentPage;
        },
        SET_LAST_PAGE(state, lastPage) {
            state.lastPage = lastPage;
        },
    },
    actions:{
        async getNotes({ commit }, payload) {
            const queryString = new URLSearchParams(payload).toString()
            const response = await axios.get(`api/client/notes?${queryString}`);
            const responseData = response.data;
            commit('SET_NOTES', responseData.data.notes);
            commit('SET_CURRENT_PAGE', responseData.data.meta.current_page);
            commit('SET_LAST_PAGE', responseData.data.meta.last_page);
        },
        async create({ commit, dispatch },payload) {
            try {
                await axios.get('/sanctum/csrf-cookie');
                const response = await axios.post(`api/client/notes`, payload);
                const responseData = response.data;
                dispatch('getNotes');
                toast.success(responseData.message);
            } catch (e) {
                throw e;
            }
        },
        async update({ commit }, payload) {
            try {
                await axios.get('/sanctum/csrf-cookie')
                const response = await axios.put(`api/client/notes/${payload.id}`, payload);
                const responseData = response.data;
                commit('SET_UPDATED_NOTE', responseData.data.note);
                toast.success(responseData.message);
            } catch (e) {
                throw e;
            }
        },
        async delete({ commit, dispatch }, payload) {
            try {
                const response = await axios.delete(`api/client/notes/${payload.id}`);
                const responseData = response.data;
                commit('DELETE_NOTE', payload.id);
                dispatch('getNotes');
                toast.success(responseData.message);
            } catch (e) {
                throw e;
            }
        },
    }
}
