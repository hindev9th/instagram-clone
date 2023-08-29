/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from "vue";
import VueRouter from 'vue-router';
import InfiniteLoading from "vue-infinite-loading";
import routes from './router/index';
import store from "./stores/index";

window.Vue = require('vue');
window.Bus = new Vue();

Vue.use(VueRouter);
Vue.use(InfiniteLoading,{
    props: {
        spinner: 'waveDots',
        /* other props need to configure */
    },
});

const router = new VueRouter({
    routes,
    mode : 'history',
    scrollBehavior (to, from, savedPosition) {
        return { x: 0 ,y : 0}
    }
})
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        if (!window.localStorage.getItem('tk')){
            next({name : 'login'});
        } else {
            next() // go to wherever I'm going
        }
    } else {
        let modalBackground = document.querySelector('.modal-backdrop')
        let body = document.querySelector('body');
        if (modalBackground) {
            body.classList.remove('modal-open');
            modalBackground.remove()
        }
        // do other stuff
        next()
    }


})

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('app-component', require('./components/pages/layouts/App').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    store : store,
});
