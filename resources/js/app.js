/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import Vuetify from "vuetify";
import 'vuetify/dist/vuetify.min.css'
import moment from 'moment';

Vue.use(Vuetify);

const vuetify = new Vuetify({
    icons: {
        iconfont: "mdi" // default - only for display purposes
    },
    theme: {
        themes: {
            light: {
                primary: "#2CCE7A"
            }
        }
    }
});

import { VueMaskDirective } from 'v-mask'
Vue.directive('mask', VueMaskDirective);


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('action-page', require('./pages/MyActionsPage.vue').default);
Vue.component('recipients-page', require('./pages/RecipientsPage.vue').default);
Vue.component('transfer-page', require('./pages/TransfersPage.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    vuetify
});

Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('MM/DD/YYYY hh:mm')
    }
});
