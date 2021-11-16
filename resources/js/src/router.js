import Vue from 'vue'
import VueRouter from "vue-router";
import store from './store';

Vue.use(VueRouter)

const AppTemplate = () => import('./layout/Template');
const Home = () => import('./pages/Home');
const Login = () => import('./pages/Login');

const Router = new VueRouter({
    mode: 'history',
    base: '/',
    routes: [
        {
            path: '',
            component: AppTemplate,
            children: [
                {
                    path: '/',
                    name: 'Root',
                    meta: {
                        requiresAuth: false,
                    },
                    redirect: {name: 'home'},
                },
                {
                    path: '/home',
                    name: 'home',
                    component: Home,
                    meta: {},
                },
            ],
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: {},
        }
    ]
})

Router.beforeEach(async (to, from, next) => {
    if (store.getters['auth/isAuthenticated']) {
        next()
        return
    }

    if (to.path === '/login') {
        next()
        return
    }
    const url = new URLSearchParams(window.location.search).get('token');
    const token = localStorage.getItem('access_token') ?? url;

    if (!token) {
        next('/login');
    }

    store.dispatch('auth/login', token).then(() => {
        window.axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
        next('/home')
    })
});


export default Router