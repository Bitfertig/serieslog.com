console.log('It`s working.');

// import for all css/scss data
import './css/tailwind.css'; // Tailwind CSS
import './style.scss';


import Vue from 'vue';
import App from './vue/app.vue';



// Don't warn about using the dev version of Vue in development.
Vue.config.productionTip = false;

import _ from 'lodash';
Vue.set(Vue.prototype, '_', _);


window.vm = new Vue({
    render: h => h(App),
}).$mount('#app');

