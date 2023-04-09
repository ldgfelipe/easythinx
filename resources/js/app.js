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

// import socket io
/*
import VueSocketio from 'vue-socket.io';
Vue.use(new VueSocketio({
    debug: true,
    connection: 'http://localhost:3000',
}));
*/

import storedata from './Store/index';

const store = new Vuex.Store(
    storedata
 )

import { Drag, Drop } from 'vue-drag-drop';

///import team builder

Vue.component('drag', Drag);
Vue.component('drop', Drop);

import { VueEditor } from "vue2-editor";

Vue.component('vue-editor', VueEditor);
Vue.component('dashoardterminal', require('./components/dashoardTerminal.vue').default);
Vue.component('componentearchivos', require('./components/componenteArchivos.vue').default);
Vue.component('componentechat', require('./components/componenteChat.vue').default);
Vue.component('componentetareas', require('./components/componenteTareas.vue').default);
Vue.component('componenteproyectos', require('./components/componenteProyectos.vue').default);
Vue.component('componenteiconos', require('./components/componenteIconos.vue').default);
Vue.component('componenteperfil', require('./components/administrador/componentePerfil.vue').default);
Vue.component('componentecontactos', require('./components/componenteContactos.vue').default);


//// alertas snackbar

Vue.component('snackbar', require('./components/snackbar.vue').default);


//// componentes administrador
Vue.component('componenteconfiguracion', require('./components/administrador/componenteConfiguracion.vue').default);
Vue.component('componentecms', require('./components/administrador/componenteCMS.vue').default);

//// componentes config
Vue.component('usuarios', require('./components/administrador/config/usuarios.vue').default);

//// componentes CMS
Vue.component('editorhtml', require('./components/administrador/cms/componenteEditorHTMLBuilder.vue').default);
Vue.component('paginas', require('./components/administrador/cms/paginas.vue').default);
Vue.component('menus', require('./components/administrador/cms/menus.vue').default);
Vue.component('piedepagina', require('./components/administrador/cms/piedepagina.vue').default);
Vue.component('redessociales', require('./components/administrador/cms/redessociales.vue').default);

//////// componentes
Vue.component('button1',require('./components/administrador/cms/modulos/boton1.vue').default);
Vue.component('seccion1',require('./components/administrador/cms/modulos/seccion1.vue').default);

/////// grid
Vue.component('grid1',require('./components/administrador/cms/grid/grid1.vue').default);
Vue.component('grid2',require('./components/administrador/cms/grid/grid2.vue').default);
Vue.component('grid3',require('./components/administrador/cms/grid/grid3.vue').default);
Vue.component('grid4',require('./components/administrador/cms/grid/grid4.vue').default);




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
