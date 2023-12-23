import {useToast} from "vue-toastification";
import store from '../store';
import router from "../router";
export default function setup() {
    window.axios.interceptors.response.use(
        response => {
            if (response.status === 200 || response.status === 201 || response.status === 204) {
                return Promise.resolve(response);
            } else {
                return Promise.reject(response);
            }
        },
        error => {
            const status = error.response ? error.response.status : null;
            const toast = useToast();
            if (status === 400) {
                toast.error(error.response.data.message);
            } else if (status === 401) {
                toast.error(error.response.data.message);
                store.dispatch('resetAllModules')
                    .then(response => {})
                    .catch(error => {});
                router.push({path: '/login'}).catch(error => {});
            } else if (status === 404) {
                toast.error(error.response.data.message);
            } else if (status === 419) {
                window.location.reload();
                toast.error(error.response.data.message);
            }

            return Promise.reject(error);
        }
    );
}
