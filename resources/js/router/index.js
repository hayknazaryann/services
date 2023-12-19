import { createRouter, createWebHistory } from "vue-router";

import Index from '../views/client/Index.vue';
import Login from '../views/client/auth/Login.vue';
import Register from '../views/client/auth/Register.vue';

const routes = [
    {
        path: '/',
        name: 'home',
        component: Index
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/register',
        name: 'register',
        component: Register
    },

]

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    next()
})

export default router
