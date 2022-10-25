/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


import { createApp } from 'vue';
import { createI18n } from 'vue-i18n';
import { createStore } from 'vuex';
import { createRouter, createWebHistory } from 'vue-router';
import AppComponent from './components/App';
import en from './lang/en.json';
import vi from './lang/vi.json';
import routes from './routes.js';
import stores from './store/stores';
import Echo from "laravel-echo";
window.Pusher = require('pusher-js');
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
});

const i18n = createI18n({
    locale: 'vi',
    messages: {
        en: en,
        vi: vi
    },
});

const router = createRouter({
    history: createWebHistory(),
    routes
});

const store = createStore(stores);

const app = createApp(AppComponent);
app.use(i18n);
app.use(store);
app.use(router);

app.mount('#app');