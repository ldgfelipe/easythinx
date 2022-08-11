/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
window.Vue = require('vue').default;
import vuetify from './vuetify';

//support vuex
import Vuex from 'vuex'
Vue.use(Vuex)

import storedata from './Store/index';

const store = new Vuex.Store(
    storedata
 )
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('dashoardterminal', require('./components/dashoardTerminal.vue').default);
Vue.component('componentearchivos', require('./components/componenteArchivos.vue').default);
Vue.component('componentechat', require('./components/componenteChat.vue').default);
Vue.component('componentetareas', require('./components/componenteTareas.vue').default);
Vue.component('componenteproyectos', require('./components/componenteProyectos.vue').default);
Vue.component('componenteiconos', require('./components/componenteIconos.vue').default);
Vue.component('componenteperfil', require('./components/componentePerfil.vue').default);
Vue.component('componentecontactos', require('./components/componenteContactos.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
if(document.getElementById('app')){
const app = new Vue({
    el: '#app',
    vuetify,
    store
});
}
