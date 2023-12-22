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
            middleware: 'guest',
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
    // Set document title based on route meta information
    document.title = `${to.meta.title}`;

    // Retrieve authentication status from Vuex store
    const isAuthenticated = store.state.profile.isAuthenticated;

    // Check if the route is marked as a guest route
    const isGuestRoute = to.meta.middleware === 'guest';

    // Check middleware and authentication status for route access
    if (isGuestRoute) {
        // Allow guest routes without authentication check
        next();
    } else {
        // For non-guest routes, check authentication status
        isAuthenticated ? next() : next({ name: 'login' });
    }
});


export default router
