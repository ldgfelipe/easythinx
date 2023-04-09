<template>
    <div>
        <v-card>
            <v-card-text>
                <v-row>
                    <v-col cols="10">
                        <v-select
                            label="Seleccione un proyecto"
                            :items="valproy"
                            item-text="nombre"
                            item-value="id"
                            @change="cambiarDatos($event)"
                        ></v-select>
                    </v-col>
                    <v-col cols="2">
                        <v-btn v-if="sesion.tipo_usuario>=1" class="greenD" @click="adminproyect = true"
                            ><v-icon class="white--text"
                                >mdi-form-select</v-icon
                            ></v-btn
                        >
                        <v-btn class="greenD" @click="loadProyectos()"
                            ><v-icon class="white--text"
                                >mdi-reload</v-icon
                            ></v-btn
                        >
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>

        <v-dialog v-model="adminproyect" fullscreen persistent>
            <v-card>
                <v-card-title class="greenD white--text">
                    Administrador de Proyectos
                    <v-spacer></v-spacer>
                    <v-btn class="white" @click="NuevoProyecto()">
                        <v-icon class="greenD--text">mdi-plus</v-icon>
                    </v-btn>
                    <v-btn class="white" @click="adminproyect = false">
                        <v-icon class="greenD--text">mdi-close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <v-data-table :headers="tituloproyectos" :items="proyectos">
                        <template v-slot:item.edit="{ item }">
                            <v-btn
                                class="greenD white--text"
                                @click="editarProyecto(item)"
                                ><v-icon>mdi-pencil</v-icon></v-btn
                            >
                        </template>
                        <template v-slot:item.status="{ item }">

                            <v-chip
                                v-if="item.status === 1"
                                class="greenD white--text"
                                >Activo</v-chip
                            >
                            <v-chip
                                v-if="item.status === 0"
                                class="Grey white--text"
                                >Inactivo</v-chip
                            >

                            <v-chip
                                v-if="item.status === 2"
                                class="Grey white--text"
                                >Concluido</v-chip
                            >
                        </template>
                    </v-data-table>

                    <v-dialog v-model="addp" max-width="500" persistent>
                        <v-card>
                            <v-card-title class="greenD white--text">
                                Registra Proyecto <v-spacer></v-spacer>
                                    <v-btn class="white greenD--text">
                                        <v-icon @click="addp=false">mdi-close</v-icon>
                                    </v-btn>
                            </v-card-title>
                            <v-card-text>
                                <br />
                                <v-text-field
                                    :readonly="perminput"
                                    outlined
                                    v-model="addproyect.nombre"
                                    label="Nombre del proyecto"
                                ></v-text-field>
                                <v-textarea
                                    :readonly="perminput"
                                    outlined
                                    v-model="addproyect.desc"
                                    label="Descripción"
                                ></v-textarea>
                                <v-select
                                    v-if="addproyect.action === 'editar'"
                                    :readonly="perminput"
                                    v-model="addproyect.id_create"
                                    chips
                                    label="administradores"
                                    multiple
                                    outlined
                                    :items="usuarios"
                                ></v-select>

                                <v-select
                                    v-if="addproyect.action === 'editar'"
                                    :readonly="perminput"
                                    v-model="addproyect.id_collaborate"
                                    chips
                                    label="colaboradores"
                                    multiple
                                    outlined
                                    :items="usuarios"
                                ></v-select>


                                <hr />
                                <v-select  v-model="addproyect.status" :items="statusProyectos" item-text="text" item-value="value"></v-select>
                                <!------<v-switch
                                    :disabled="perminput"
                                    v-model="addproyect.status"
                                    :label="
                                        addproyect.status
                                            ? 'Activo'
                                            : 'Inactivo'
                                    "
                                ></v-switch>---->

                                <v-btn
                                    v-if="
                                        valsesion &&
                                        addproyect.action === 'editar'
                                    "
                                    class="red white--text"
                                    @click="eliminaProyecto(addproyect)"
                                    ><v-icon>mdi-delete</v-icon></v-btn
                                >
                                <v-progress-circular
                                v-if="!stsave"
                                :width="4"
                                color="green"
                                indeterminate
                                ></v-progress-circular>
                                <v-btn
                                    v-if="valsesion===true && stsave===true"
                                    @click="GuardarProyecto()"
                                    class="greenD white--text"
                                    >Guardar</v-btn
                                >
                            </v-card-text>
                        </v-card>
                    </v-dialog>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
/**
 *Componente proyectos
 * @module components/componenteProyectos
 *
 */
import  {mapState, mapActions, mapMutations} from 'vuex'
export default {
    /**
     * Data de sistema
     * @name Data
     * @type {Object}
     * @property {Boolean} addp  controla el estado de la ventana de dialogo para Crear un nuevo proyecto
     * @property {Boolean} adminproyect controla el estado de la ventana de dialog Administrador de Proyectos
     * @property {Objeto} addproyect Objeto para crear un proyecto
     * @property {Boolean} stsave  carga el preload al guardar
     * @property {Object} tituloproyectos Titulos de tabla de proyectos
     *
     */
    data() {
        return {
            addp: false,
            adminproyect: false,
            addproyect: {},
            stsave:true,
            tituloproyectos: [
                {
                    text: "Proyecto",
                    value: "nombre",
                },
                {
                    text: "Descripción",
                    value: "desc",
                },
                {
                    text: "Status",
                    value: "status",
                },
                {
                    text: "Editar",
                    value: "edit",
                },

            ],
            statusProyectos:[
                {
                    text:'Activo',
                    value:1
                },
                {
                    text:'Inactivo',
                    value:0
                },
                {
                    text:'Concluido',
                    value:2
                }
            ]
        };
    },
    /**
     * @name Mounted
     * @property Ejecuta - this.loadProyect()
     */
    mounted() {
        this.loadProyectos();
    },

    /**
     * @name Computad
     * @property mapState([]) - proyectos, usuarios, csrf, sesion, url, socket
     * @property valproy() - filtra el nombre del producto del array productos para mostrarlo en select
     * @property valsesion() - Verifica si el usurio tiene permisos de administrador de proyecto
     * @property perminput() - Verifica si el usuario tiene permisos de administrador para inputs
     *
     */
    computed: {
        ...mapState(['proyectos','usuarios','csrf', 'sesion', 'url','socket']),

        valproy() {
            var dataproy = [];
            if (this.proyectos.length > 0) {
                this.proyectos.map((e) => {
                    if (e.status === 1) {
                        dataproy.push({ nombre: e.nombre, id: e.id });
                    }
                });
            }
            return dataproy;
        },

        valsesion() {
            var permiso = false;

            if (
                this.addproyect.action === "editar" &&
                this.addproyect.id_create
            ) {
                this.addproyect.id_create.map((r) => {
                    if (r === this.sesion.email) {
                        permiso = true;
                    }
                });
            }

            if (this.addproyect.action === "crear") {
                permiso = true;
            }

            return permiso;
        },
        perminput() {
            var permiso = true;
            if (
                this.addproyect.action === "editar" &&
                this.addproyect.id_create
            ) {
                this.addproyect.id_create.map((r) => {
                    if (r === this.sesion.email) {
                        permiso = false;
                    }
                });
            }
            if (this.addproyect.action === "crear") {
                permiso = false;
            }
            return permiso;
        },
    },
    /**
     *@name Methods
     *@property mapActions([]) - cargaProyectos, LoadProyecto
     *@property cambiaDatos() - verifica el id de proyecto sobre el cual realiza los cambios y emite el cambio al padre $emit
     */
    methods: {
        ...mapMutations(['cargaProyectoSelect','cambiaLoader']),
        ...mapActions(['cargaProyectos','LoadProyecto']),
        cambiarDatos(event) {

            console.log('cambia dato '+event)

            this.proyectos.map((p) => {
                if (p.id === event) {
                    this.LoadProyecto(p)
                }
            });
        },
        eliminaProyecto() {
            if (
                confirm(
                    "Seguro que desea eliminar el proyecto " +
                        this.addproyect.nombre
                )
            ) {
                this.addproyect.action = "eliminar";
                fetch(this.url + "registraproyecto", {
                    method: "POST",
                    headers: {
                        "Content-type": "application/json",
                        "X-CSRF-TOKEN": this.csrf,
                    },
                    body: JSON.stringify(this.addproyect),
                })
                    .then((res) => res.json())
                    .then((res) => {
                        console.log(res);
                        this.addp = false;
                        this.loadProyectos();
                        this.cambiaLoader(true);

                    });
            }
        },
        NuevoProyecto() {
            this.addproyect = {};
            this.addproyect.action = "crear";
            this.addproyect.status = true;
            this.addp = true;
        },
        editarProyecto(item) {
            this.addproyect = {};
            this.addp = true;
            this.addproyect.action = "editar";
            this.addproyect.id = item.id;
            this.addproyect.id_create = JSON.parse(item.id_create);
            this.addproyect.id_collaborate = JSON.parse(item.id_collaborate);
            this.addproyect.nombre = item.nombre;
            this.addproyect.desc = item.desc;
            this.addproyect.status = item.status;
            this.addproyect.notas = item.notas;
        },
        loadProyectos(id) {
            var payload = {
                acces: "data",
            };

            var data={
                url:this.url,
                payload:payload,
                csrf:this.csrf
            }
     this.cargaProyectos(data)
     .then((res)=>{
        console.log(res)
        if(id){
            setTimeout(()=>{
                this.cambiarDatos(id)
                },1500)

                }
     })
            //// carga de proyecto con mapAction
            this.addproyect = {};

        },
        GuardarProyecto() {
            this.stsave=false
            var parProyect =this.addproyect
            fetch(this.url + "registraproyecto", {
                method: "POST", // or 'PUT'
                body: JSON.stringify(this.addproyect), // data can be `string` or {object}!
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": this.csrf,
                },
            })
                .then((res) => res.json())
                .catch((error) => console.error("Error:", error))
                .then((response) => {
                    this.addp = false;
                    if(this.addproyect.status===2){
                        this.cargaProyectoSelect({})
                    }else{
                    this.loadProyectos(parProyect.id);
                    }
                        this.stsave=true

                });
        },
    },

};
</script>
