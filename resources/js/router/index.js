import { createRouter, createWebHistory } from "vue-router";
import store from '../store'

import Index from '../views/client/Index.vue';
import Profile from '../views/client/user/Profile.vue';
import Login from '../views/client/auth/Login.vue';
import Register from '../views/client/auth/Register.vue';
import ForgotPassword from '../views/client/auth/ForgotPassword.vue';
import ResetPassword from '../views/client/auth/ResetPassword.vue';
import VerifyEmail from "../views/client/auth/VerifyEmail.vue";
import NotesIndex from "../views/client/notes/Index.vue"

const routes = [
    {
        path: '/',
        name: 'home',
        meta:{
            middleware: 'guest',
            accessAuth: true,
            title: 'Home',
        },
        component: Index
    },
    {
        path: '/login',
        name: 'login',
        meta:{
            middleware: 'guest',
            accessAuth: false,
            title: 'Login',
        },
        component: Login
    },
    {
        path: '/register',
        name: 'register',
        meta:{
            middleware: 'guest',
            accessAuth: false,
            title: 'Register',
        },
        component: Register
    },
    {
        path: '/password-forgot',
        name: 'password.forgot',
        component: ForgotPassword,
        meta:{
            middleware: 'guest',
            accessAuth: false,
            title: 'Forgot Password',
        },
    },
    {
        path: '/password-reset',
        name: 'password.reset',
        component: ResetPassword,
        props: (route) => ({
            token: route.query.token,
            email: route.query.email,
        }),
        meta:{
            middleware: 'guest',
            accessAuth: false,
            title: 'Reset Password',
        },
    },
    {
        path: '/verify-email/:id/:hash',
        name: 'verify.email',
        component: VerifyEmail,
        props: (route) => ({
            id: route.params.id,
            hash: route.params.hash,
        }),
        meta:{
            middleware: 'guest',
            accessAuth: true,
            title: 'Verify Email',
        },
    },
    {
        path: '/profile',
        name: 'profile',
        meta:{
            middleware: 'auth',
            accessAuth: true,
            title: 'Profile',
        },
        component: Profile
    },

    {
        path: '/notes',
        name: 'notes.index',
        meta:{
            middleware: 'auth',
            accessAuth: true,
            title: 'Notes',
        },
        component: NotesIndex
    },

]

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    // Set document title based on route meta information
    const meta = to.meta;
    document.title = `${meta.title}`;

    // Retrieve authentication status from Vuex store
    const isAuthenticated = store.state.profile.isAuthenticated;

    // Check if the route is marked as a guest route
    const isGuestRoute = meta.middleware === 'guest';

    // Check middleware and authentication status for route access
    if (isGuestRoute) {
        // Allow guest routes without authentication check
        isAuthenticated && !meta.accessAuth ? next({ name: 'home' }) : next();

    } else {
        // For non-guest routes, check authentication status
        isAuthenticated ? next() : next({ name: 'login' });
    }
});


export default router
