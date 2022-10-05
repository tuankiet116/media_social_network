/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


import Vue from 'vue';
import VueI18n from 'vue-i18n';
import AppComponent from './components/App';
import en from './lang/en.json';
import vi from './lang/vi.json';

Vue.use(VueI18n);
const i18n = new VueI18n({
    locale: navigator.language,
    messages: {
        en: en,
        vi: vi
    },
});

i18n.locale = 'vi';

const app = new Vue({
    el: '#app',
    i18n,
    components: {
        AppComponent
    },
    template: '<AppComponent></AppComponent>',
});
