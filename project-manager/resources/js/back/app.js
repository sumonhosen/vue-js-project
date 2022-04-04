import store from './store';

import Vue from 'vue'

import vSelect from 'vue-select'
Vue.component('v-select', vSelect)

Vue.component('create-purchase', require('./components/purchase/CreateComponent').default);

const app = new Vue({
    store,
    el: '#app',
});

