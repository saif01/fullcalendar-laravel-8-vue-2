require('./bootstrap');

window.Vue = require('vue').default;

import  BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue)
 

Vue.use(require('vue-moment'));


Vue.component('example-component', require('./components/ExampleComponent.vue').default);



const app = new Vue({
    el: '#app',
});
