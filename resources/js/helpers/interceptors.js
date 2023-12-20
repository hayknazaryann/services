import axios from 'axios';
import router  from '../router'
import store  from '../store'

export default function setup() {
    axios.interceptors.response.use(
        response => {
            if (response.status === 200 || response.status === 201 || response.status === 204) {
                return Promise.resolve(response);
            } else {
                return Promise.reject(response);
            }
        },
        (error) => {
            switch (error.response.status) {
                case 400:
                case 500:

                    break;
                case 401:
                    store.dispatch('auth/logout')
                    setTimeout(() => {
                        router.replace({
                            path: "/login",
                            query: { redirect: router.currentRoute.fullPath }
                        });
                    }, 1000);
                    break;
                case 403:
                    // store.commit('auth/resetState')
                    setTimeout(() => {
                        router.replace({
                            path: "/login",
                            query: { redirect: router.currentRoute.fullPath }
                        });
                    }, 1000);
                    break;
                case 404:
                    router.replace({
                        path: "/",
                    });

                    break;
                case 502:
                    // store.commit('auth/resetState')
                    setTimeout(() => {
                        router.replace({
                            path: "/login",
                            query: { redirect: router.currentRoute.fullPath }
                        });
                    }, 1000);
            }
            return Promise.reject(error.response);
        }
    );
}
