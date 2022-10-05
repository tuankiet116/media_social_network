/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


import Vue from 'vue';
import VueI18n from 'vue-i18n';
import AppComponent from './components/App';
import en from './lang/en';
import vi from './lang/vi';


const i18n = new VueI18n({
    en: en,
    vi: vi
});
Vue.use(i18n);

function detectLanguageBrowser() {

}

const app = new Vue({
    el: '#app',
    components: {
        AppComponent
    },
    template: '<AppComponent></AppComponent>'
});
