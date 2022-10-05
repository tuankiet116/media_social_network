/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


import Vue from 'vue';
import VueI18n from 'vue-i18n';
import AppComponent from './components/App';


const i18n = {}
Vue.use(VueI18n);

function detectLanguageBrowser() {

}

const app = new Vue({
    el: '#app',
    components: {
        AppComponent
    },
    template: '<AppComponent></AppComponent>'
});
