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
import CKEditor from "@ckeditor/ckeditor5-vue";
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
    base: '/',
    history: createWebHistory(),
    routes
});

const store = createStore(stores);

const app = createApp(AppComponent);
app.use(CKEditor);
app.use(i18n);
app.use(store);
app.use(router);

app.mount('#app');