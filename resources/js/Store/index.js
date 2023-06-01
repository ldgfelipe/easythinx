/**
 * Store de Vuex
 * @module store/index
 *
 */
 const moment = require('moment');
export default {
    /**
    * The Vuex 'state' object.
 * @name State
 * @type {object}
 * @property {Array} usuarios - toma todos los usuarios de la lista de contactos
 * @property {String} csrf - "token" CSRF llave de protección contra falcificación inicia en dashboardTerminal.vue
 * @property {String} url - la url del sitio se genera incia en dashboardTerminal.vue
 * @property {String} socketid - El id de sesión de usuario en el socket se asigna en componenteChat.vue
 * @property {Object} socket - es la libreria de cliente socket se inicia en dashboardTerminal.vue
 * @property {Array} proyectos - Es la lista de proyectos que carga por usuarios
 * @property {Array} listanot -
 * @property {Object} listauser -
 * @property {Object} proyectoSelect - Es el proyecto seleccionado
 * @property {Boolean} loader - El statuds de preload para reflejar el proceso de carga
 * @property {Object} sesion - Son los datos de la sesión de usuario iniciada
 * @property {Object} tareas - Es el listado de tareas por proyecto
 * @property {Array} userproy - Es el listado de usuarios por proyecto
 * @property {Array} archivos - Es el listado de archivos que carga por proyecto
 * @property {Boolean} sendnot - Es el statos de envío de notificación
 * @property {Object} snackbar - Se utiliza para registrar alertas del sistema
 */

    state: {
        usuarios: [],
        csrf: "",
        url: "",
        socketid: "",
        socket: {},
        listanot: [],
        listauser: {},
        proyectos: [],
        proyectoSelect: {},
        loader: false,
        sesion: {},
        tareas: [],
        userproy: [],
        archivos: [],
        moment:moment,
        sendnot: false,
        snackbar:{
            snackbar:false,
            color:'',
            text:''
        }
    },


/**
 * The module 'setters' object.
 * @name Mutations
 * @type {object}
 * @mutator {Object} cargaProyectoSelect=proyectoSelect Carga al state proyectoSelect
 * @mutator {Boolean} cargaSendnot=sendnot Cambia status de state sendnot para aleta de notificaciones.
 * @mutator {Array} cargaUserProy=userproy Carga los usuarios por proyecto
 * @mutator {Array} cargaArchivos=archivos Carga listado de archivos
 * @mutator {Array} cargaTareas=tareas Carga listado de tareas de proyecto seleccionado
 * @mutator {Object} cargaSesion=sesion Carga el objeto de sesión de usuario iniciada
 * @mutator {Boolean} cambiaLoader=loader Cambia status true o false para mostrar o desaparecer un loader en el sitio
 * @mutator {Object} cargaSocket=socket Carga la libreria cliente socket
 * @mutator {String} cargaCSRF=csrf Carga la llave privada en csrf
 * @mutator {String} cargaidSocket=socketid Carga el id de socket de sesión en proyecto
 * @mutator {String} cargaURL=url Carga la url del sistema en que esta corriendo la pagina
 * @mutator {Object} cargaListaUsuarios=listauser  carga la lista de usuarios [gral] general, [coll] collaborador y [admin] administrador
 * @mutator {Array} guardausuarios=usuarios Carga usuarios de lista de contacto en state usuarios
 * @mutator {Array} cargaNotificaciones=listanot Carga listado de notificaciones
 * @mutator {Object} cargaProyecto=proyectos Carga lista de proyectos creados y/o asignados por y para el usuario
 * @mutator {Object} cambia status de snackbar
*/

    mutations: {

        cargaProyectoSelect(state, proyecto) {
            state.proyectoSelect = proyecto
        },
        cargaSendnot(state, data) {
            state.sendnot = data
        },
        cargaUserProy(state, data) {
            state.userproy = data
        },
        cargaArchivos(state, data) {
            state.archivos = data
        },
        cargaTareas(state, data) {
            state.tareas = data
        },
        cargaSesion(state, data) {
            state.sesion = data
        },
        cambiaLoader(state, data) {
            state.loader = data
        },
        cargaSocket(state, socket) {
            state.socket = socket
        },
        cargaCSRF(state, datos) {
            state.csrf = datos
        },
        cargaridSocket(state, id) {
            state.socketid = id
        },
        cargaURL(state, url) {
            state.url = url
        },
        cargaListaUsuarios(state, datos) {
            state.listauser = {
                gral: datos.gral,
                coll: datos.coll,
                admin: datos.admin
            }
        },
        guardausuarios(state, datos) {
            state.usuarios = datos
        },
        cargaNotificaciones(state, notifi) {
            state.listanot = notifi
        },
        cargaProyectos(state, proyectos) {
            state.proyectos = proyectos
            return "data";
        },
        cambiaSnackbar(state, datos){
            state.snackbar=datos
        }

    },


    actions: {

/**
 * cargaNotifi carga las notificaciones llamando a la API/carganotificaciones ejecuta commit('cargaNotificaciones', res).
 * @action cargaNotifi=data
 * @param {Array} data recive payload con email.
 * @returns {void}
 */

        cargaNotifi({ state, commit }, data) { /// notificaciones al usuario
            console.log(data)
            let payload = {
                email: data.email
            }
            fetch(state.url + 'carganotificaciones', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': state.csrf
                },
                body: JSON.stringify(payload)
            })
                .then(res => res.json())
                .then((res) => {
                    commit('cargaNotificaciones', res)
                })


        },

/**
 * enviaNotificacion Guarda en API /guardanotificacion y emite a [notifica_privado] de socket, API/guardanotificacion.
 * @action enviaNotificacion=datosnot
 * @param {Array} datosnot recive payload con datos para notificaciones.
 * @returns {void}
 */
        enviaNotificacion({ state, commit }, datosnot) {
            datosnot.name_rem = state.sesion.name;
            datosnot.id_rem = state.sesion.id;
            datosnot.socket_rem = state.socketid;


            fetch(state.url + 'guardanotificacion', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': state.csrf
                },
                body: JSON.stringify(datosnot)
            })
                .then(res => res.json())
                .then((res) => {
                    commit('cargaSendnot', false)

                    //// envia mensaje a id de notificacion
                    state.socket.emit('notifica_privado', datosnot);
                })
        },
/**
 * loadUserproy carga datos de usuario ejecuta commit('cargaUserProy', filteruser).
 * @action loadUserproy
 * @returns {void}
 */


        loadUserproy({ commit, state }) {

            var colaboradores = []
            var creadores = []
            if (state.proyectoSelect.id_collaborate) {
                colaboradores = JSON.parse(state.proyectoSelect.id_collaborate)
            }
            if (state.proyectoSelect.id_create) {
                creadores = JSON.parse(state.proyectoSelect.id_create)
            }
            var usuarios = [...colaboradores, ...creadores]
            var filteruser = usuarios.filter(Boolean);

            commit('cargaUserProy', filteruser)

        },
/**
 * cargaUsuarios carga los usuarios de contacto segun proyecto seleccionado Api/cargausuarios  ejecuta commit('guardausuarios', res)
 * @action cargaUsuarios=datos
 * @patams {Object} datos - recive datos de objecto con el id de usuario
 * @returns {void}
 */
        cargaUsuarios({ commit, state }, datos) {
            var payload = {
                acces: "data",
                id_user: datos.id
            }
            fetch(state.url + "cargausuarios", {
                method: 'POST',
                headers: {
                    'Content-type': 'application/json',
                    'X-CSRF-TOKEN': state.csrf
                },
                body: JSON.stringify(payload)
            })
                .then(res => res.json())
                .then((res) => {
                    commit('guardausuarios', res)
                })
        },

/**
 * cargaProyectos Carga Array de proyectos Api/cargaproyectos ejecuta commit('cargaProyectos', resp);
 * @action cargaProyectos=datos
 * @param {Object} datos - recive payload con indormación del usuario para responder con la info de los proyectos asignados o creados
 * @returns {void}
 */
        cargaProyectos({ commit, state }, datos) {

            fetch(state.url + "cargaproyectos", {
                method: "POST",
                headers: {
                    "Content-type": "application/json",
                    "X-CSRF-TOKEN": state.csrf,
                },
                body: JSON.stringify(datos.payload),
            })
                .then((res) => res.json())
                .catch((error) => console.error("Error", error))
                .then((resp) => {
                    commit('cargaProyectos', resp);

                });
        },
 /**
 * LoadProyecto Carga proyecto seleccionado ejecuta commit('cambiaLoader', true), commit('cargaProyectoSelect', ev), commit('cargaListaUsuarios', payload), dispatch('loadUserproy'); y socket  state.socket.emit('dejandola_sala', state.socketid) para avisar el cambio de sala
 * @action LoadProyecto=ev
 * @param {Object} ev - recive la información de payload con el proyecto seleccionado y realiza la propagacion de datos para los demas componentes Mutaciones: [cargaProyectoSelect, cambiaLoader, cargaListaUsuarios]  -- Actions: [ loadUserproy ]
 * @returns {void}
 */
        LoadProyecto({ dispatch, commit, state }, ev) {
            console.log('id proyecto a cargar '+ev.id)
            commit('cambiaLoader', true)
            if (ev) {
                new Promise((res) => { res(ev) })
                    .then((ev) => {
                        if(ev){
                        ev.id_create.indexOf(state.sesion.email) > 0 ? ev.adminproy = true : ev.adminproy = false
                        commit('cargaProyectoSelect', ev)
                        console.log('cambiando de sala')
                        state.socket.emit('dejandola_sala', state.socketid)
                        /////crea listas de usuario y guarda en store para su uso en el sitio /lista colaboradores / lista administradores  de proyecto  / lista general
                        var listaGral = [] /// listado general de usuarios por proyecto
                        var listaColl = []
                        var listaAdmin = []

                        JSON.parse(ev.id_collaborate).map((p) => {
                            if (p !== null) {
                                if (listaGral.indexOf(p) === -1) {
                                    listaGral.push(p)
                                }
                                if (listaColl.indexOf(p) === -1) {
                                    listaColl.push(p)
                                }
                            }
                        })


                        JSON.parse(ev.id_create).map((p) => {
                            if (p !== null) {
                                if (listaGral.indexOf(p) === -1) {
                                    listaGral.push(p)
                                }
                                if (listaAdmin.indexOf(p) === -1) {
                                    listaAdmin.push(p)
                                }
                            }
                        })


                        let payload = {
                            gral: listaGral,
                            admin: listaAdmin,
                            coll: listaColl
                        }

                        commit('cargaListaUsuarios', payload)
                        dispatch('loadUserproy');
                        setTimeout(()=>{
                            commit('cambiaLoader', false)
                        },1000)

                     }
                    })



            }
        },
 /**
 * loadTareas Carga Array de tareas Api/cargatareas ejecuta  commit('cargaTareas', res);
 * @action loadTareas=datos
 * @returns {void}
 */
        loadTareas({ commit, dispatch, state }) {
            commit('cargaTareas', [])
            var payload = {
                id_proyecto: state.proyectoSelect.id
            }
            fetch(state.url + "cargatareas", {
                method: 'POST',
                headers: {
                    'Content-type': 'application/json',
                    'X-CSRF-TOKEN': state.csrf
                },
                body: JSON.stringify(payload)
            })
                .then(res => res.json())
                .then((res) => {

                    commit('cargaTareas', res)
                })
        },
 /**
 * loadArchivos Carga Archivos de proyecto seleccionado ejecuta commit('cargaArchivos', ret)
 * @action loadArchivos
 * @returns {void}
 */
        loadArchivos({ commit, state }) {
            var archivos = {
                id_proyecto: state.proyectoSelect.id
            }
            fetch(state.url + 'cargarachivos', {
                method: 'POST',

                headers: {
                    'Content-type': 'application/json',
                    'X-CSRF-TOKEN': state.csrf
                },
                body: JSON.stringify(archivos)
            })
                .then(res => res.json())
                .then((ret) => {
                    console.log(ret)
                    commit('cargaArchivos', ret)
                })

        },

        cambiaStatuSnackBar({commit},data){
            console.log('carga datos de snakbar')
            data.snackbar===false ? data.snackbar = true : data.snackbar = false
            commit('cambiaSnackbar',data);

        }


    }
}


