console.log('It`s working.');

// import for all scss data
import './style.scss';

import Sortable from "sortablejs";

import Vue from 'vue'
import App from './vue/app.vue';

// Don't warn about using the dev version of Vue in development.
Vue.config.productionTip = false;

import _ from 'lodash';
Vue.set(Vue.prototype, '_', _);
//Vue.set(Vue.prototype, 'Sortable', Sortable);
window.Sortable = Sortable;


window.vm = new Vue({
    render: h => h(App),
}).$mount('#app');

