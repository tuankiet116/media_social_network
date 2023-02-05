import { createApp } from 'vue';
import { createI18n } from 'vue-i18n';
import { createStore } from 'vuex';
import { createRouter, createWebHistory } from 'vue-router';
import AppComponent from './components/App';
import en from './lang/en.json';
import vi from './lang/vi.json';
import routes from './routes.js';
import stores from './store/stores';
import CKEditor from "@ckeditor/ckeditor5-vue";
import Toast, { POSITION } from "vue-toastification";
import mitt from 'mitt';
import Echo from "laravel-echo";
import "vue-toastification/dist/index.css";
import VueSelect from 'vue-select';
import VueEasyLightbox from 'vue-easy-lightbox';
// import ElementPlus from 'element-plus'
// import 'element-plus/dist/index.css';
// import 'element-plus/theme-chalk/dark/css-vars.css';

window.Pusher = require('pusher-js');
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true,
    // authEndpoint: 'pusher/user-auth',
    // csrfToken: document
    //     .querySelector('meta[name="csrf-token"]')
    //     .getAttribute("content"),
    encrypted: true,
    enabledTransports: ['ws', 'wss'],
    // wsHost: window.location.hostname,
    // wsPort: 6001,
    // disableStats: true
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
    routes,
    scrollBehavior(to, from, savedPosition) {
        return { top: 0, behavior: 'smooth' }
    },
});

const store = createStore(stores);
const emitter = mitt();

const app = createApp(AppComponent);
app.use(CKEditor);
app.use(i18n);
app.use(store);
app.use(router);
app.use(VueEasyLightbox)
// app.use(ElementPlus)
app.use(Toast, {
    position: POSITION.TOP_RIGHT
});
app.component('vue-select', VueSelect);
app.config.globalProperties.emitter = emitter;
app.directive('outsider', {
    mounted: (el, binding) => {
        el.clickOutsideEvent = event => {
            // here I check that click was outside the el and his children
            if (!(el == event.target || el.contains(event.target))) {
                // and if it did, call method provided in attribute value
                binding.value();
            }
        };
        document.addEventListener("click", el.clickOutsideEvent);
    },
    unmounted: el => {
        document.removeEventListener("click", el.clickOutsideEvent);
    },
});

app.mount('#app');