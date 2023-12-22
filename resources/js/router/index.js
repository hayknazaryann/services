import { createRouter, createWebHistory } from "vue-router";
import store from '../store'

import Index from '../views/client/Index.vue';
import Profile from '../views/client/user/Profile.vue';
import Login from '../views/client/auth/Login.vue';
import Register from '../views/client/auth/Register.vue';

const routes = [
    {
        path: '/',
        name: 'home',
        meta:{
            title: 'Home',
        },
        component: Index
    },
    {
        path: '/login',
        name: 'login',
        meta:{
            middleware: 'guest',
            title: 'Login',
        },
        component: Login
    },
    {
        path: '/register',
        name: 'register',
        meta:{
            middleware: 'guest',
            title: 'Register',
        },
        component: Register
    },
    {
        path: '/profile',
        name: 'profile',
        meta:{
            middleware: 'auth',
            title: 'Profile',
            dashboard: true,
        },
        component: Profile
    },

]

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    document.title = `${to.meta.title}`;
    if (to.meta.middleware === 'guest') {
        if (store.state.profile.isAuthenticated) {
            next({ name: 'profile' });
        } else {
            next();
        }
    } else {
        if (store.state.profile.isAuthenticated) {
            next();
        } else {
            next({ name: 'login' });
        }
    }
});

export default router
