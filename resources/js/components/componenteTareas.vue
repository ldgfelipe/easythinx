<template>
    <div>
        <v-card min-height="550px">
            <v-card-title class="greenD white--text">
                Tareas <v-spacer></v-spacer>

                <v-btn
                    v-if="proyectoSelect.adminproy"
                    class="white greenD--text"
                    @click="abreAddTareaPlantillas()"
                    title="Plantilla de tareas"
                >
                    <v-icon>mdi-plus</v-icon>
                    <v-icon>mdi-format-line-spacing</v-icon>
                </v-btn>

                <v-btn
                    v-if="proyectoSelect.adminproy"
                    class="white greenD--text"
                    @click="abreAddTarea()"
                >
                    <v-icon>mdi-plus</v-icon>
                </v-btn>
                <v-btn class="white greenD--text" @click="cargaTareas()">
                    <v-icon>mdi-reload</v-icon>
                </v-btn>
                <v-btn
                    class="white greenD--text"
                    title="Minimizar"
                    @click="minimizar()"
                >
                    <v-icon>mdi-arrow-bottom-left-bold-box</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-dialog v-model="plantillaTareas" max-width="800">
                    <v-card>
                        <v-card-title> Lista de tareas </v-card-title>
                        <v-card-text>
                            <v-card
                                v-for="(item, index) in listaPlantillas"
                                :key="'plant' + index"
                            >
                                <v-card-title class="greenD white--text">
                                    {{ item.nombre }}
                                </v-card-title>
                                <v-card-text style="overflow:auto;">
                                    <v-data-table
                                        v-if="item.tareas"
                                        :headers="[
                                            {
                                                text: 'Tarea',
                                                value: 'tarea',
                                            },
                                            {
                                                text: 'Seleccionar',
                                                value: 'select',
                                            },
                                        ]"
                                        :items="JSON.parse(item.tareas)"
                                    >
                                        <template v-slot:item.select="{ item }">
                                            <v-checkbox
                                                v-model="taeasSelect"
                                                :value="item.tarea"
                                                hide-details
                                            ></v-checkbox>
                                        </template>
                                    </v-data-table>


                                </v-card-text>
                            </v-card>

                            <v-btn class="greenD white--text" @click="addTareasMutiples()">Agregar Tareas al Proyecto</v-btn>
                        </v-card-text>
                    </v-card>
                </v-dialog>

                <br />
                <v-row>
                    <v-col cols="7" md="7">
                        <v-text-field
                            outlined
                            v-model="searchgral"
                            label="Buscar tarea"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="3" md="3">
                        <v-select
                            v-model="filstatus"
                            label="Status"
                            filled
                            :items="tipoTareas"
                        ></v-select>
                    </v-col>
                    <v-col cols="2">
                        <v-btn
                            class="greenD white--text"
                            @click="addfolder = true"
                            ><v-icon>mdi-folder</v-icon></v-btn
                        >
                        <v-dialog v-model="addfolder" max-width="400">
                            <v-card>
                                <v-card-title> Folder </v-card-title>
                                <v-card-text>
                                    <v-text-field
                                        v-model="folder"
                                    ></v-text-field
                                    ><v-btn
                                        class="greenD white--text"
                                        @click="crearfolder()"
                                        ><v-icon>mdi-folder-plus</v-icon></v-btn
                                    >
                                </v-card-text>
                            </v-card>
                        </v-dialog>
                    </v-col>
                </v-row>
                <v-btn
                    text
                    @click="
                        filtros === false ? (filtros = true) : (filtros = false)
                    "
                    >Filtrar</v-btn
                >

                <v-card v-for="(fole, index) in folders" :key="'fol' + index">
                    <v-card-title class="greenD white--text">
                        {{ fole.nombre }}
                        <v-spacer></v-spacer>
                        <v-btn
                            v-if="
                                typeof tareas[fole.nombre] !== 'undefined' &&
                                typeof tareas[fole.nombre] !== null &&
                                Object.keys(tareas[fole.nombre]).length === 0
                            "
                            class="red white--text"
                            @click="eliminaCarpeta(fole.id)"
                            ><v-icon>mdi-delete</v-icon></v-btn
                        >
                        <v-btn
                            class="white greenD--text"
                            @click="muestraCarpeta(fole.nombre)"
                            ><v-icon>{{
                                carpetas[fole.nombre] === false
                                    ? "mdi-arrow-down"
                                    : "mdi-arrow-up"
                            }}</v-icon></v-btn
                        >
                    </v-card-title>
                    <v-card-text>
                        <!-----Tabla con folder---->
                        <v-data-table
                            v-if="carpetas[fole.nombre] && tareas[fole.nombre]"
                            :headers="titulotareas"
                            :search="searchgral"
                            :items="tareas[fole.nombre]"
                            v-model="tareas[fole.nombre]"
                        >
                            <template v-slot:item.asignado="{ item }">
                                <v-chip
                                    v-if="
                                        JSON.parse(item.asignado).filter(
                                            (a) => a === sesion.email
                                        )[0] === sesion.email
                                            ? true
                                            : false
                                    "
                                    color="greenD"
                                >
                                    <v-icon class="white--text"
                                        >mdi-check</v-icon
                                    >
                                </v-chip>
                            </template>

                            <template v-slot:item.caducidad="{ item }">
                                <v-chip
                                    v-if="item.caducidad"
                                    :color="
                                        validacaducidad(item.caducidad)
                                            ? 'greenD'
                                            : 'Red'
                                    "
                                    :style="
                                        validacaducidad(item.caducidad)
                                            ? 'font-size:9px; color:black;'
                                            : 'font-size:9px; color:white;'
                                    "
                                    >{{ item.caducidad }}</v-chip
                                >
                            </template>

                            <template v-slot:item.titulo="{ item }">
                                <v-tooltip left color="success">
                                    <template v-slot:activator="{ on, attrs }">
                                        <span
                                            v-bind="attrs"
                                            v-on="on"
                                            style="cursor: pointer"
                                        >
                                            {{ item.titulo }}
                                        </span>
                                    </template>
                                    <span>
                                        Descripción:<br />
                                        {{ item.desc }}
                                        <hr />
                                        Asignado:<br />
                                        {{ item.asignado }}
                                    </span>
                                </v-tooltip>
                            </template>

                            <template v-slot:item.editar="{ item }">
                                <v-btn
                                    class="greenD white--text"
                                    @click="EditarTarea(item)"
                                >
                                    <v-icon>mdi-pencil</v-icon>
                                </v-btn>
                            </template>

                            <template v-slot:item.status="{ item }">
                                <v-chip
                                    v-if="item.status === 1"
                                    class="greenD white--text"
                                    >Pendiente</v-chip
                                >
                                <v-chip
                                    v-if="item.status === 0"
                                    class="Grey white--text"
                                    >Finalizado</v-chip
                                >
                            </template>
                        </v-data-table>
                        <!-----Tabla con folder---->
                    </v-card-text>
                </v-card>

                <!-----Tabla sin folder---->
                <v-data-table
                    :headers="titulotareas"
                    :search="searchgral"
                    :items="tareas.sinfolder"
                    v-if="
                        typeof tareas.sinfolder !== 'undefined' &&
                        typeof tareas.sinfolder !== null &&
                        Object.keys(tareas.sinfolder).length > 0
                    "
                >
                    <template v-slot:item.asignado="{ item }">
                        <v-chip
                            v-if="
                                JSON.parse(item.asignado).filter(
                                    (a) => a === sesion.email
                                )[0] === sesion.email
                                    ? true
                                    : false
                            "
                            color="greenD"
                        >
                            <v-icon class="white--text">mdi-check</v-icon>
                        </v-chip>
                    </template>

                    <template v-slot:item.caducidad="{ item }">
                        <v-chip
                            v-if="item.caducidad"
                            :color="
                                validacaducidad(item.caducidad)
                                    ? 'greenD'
                                    : 'Red'
                            "
                            :style="
                                validacaducidad(item.caducidad)
                                    ? 'font-size:9px; color:black;'
                                    : 'font-size:9px; color:white;'
                            "
                            >{{ item.caducidad }}</v-chip
                        >
                    </template>

                    <template v-slot:item.titulo="{ item }">
                        <v-tooltip left color="success">
                            <template v-slot:activator="{ on, attrs }">
                                <span
                                    v-bind="attrs"
                                    v-on="on"
                                    style="cursor: pointer"
                                >
                                    {{ item.titulo }}
                                </span>
                            </template>
                            <span>
                                Descripción:<br />
                                {{ item.desc }}
                                <hr />
                                Asignado:<br />
                                {{ item.asignado }}
                            </span>
                        </v-tooltip>
                    </template>

                    <template v-slot:item.editar="{ item }">
                        <v-btn
                            class="greenD white--text"
                            @click="EditarTarea(item)"
                        >
                            <v-icon>mdi-pencil</v-icon>
                        </v-btn>
                    </template>

                    <template v-slot:item.status="{ item }">
                        <v-chip
                            v-if="item.status === 1"
                            class="greenD white--text"
                            >Pendiente</v-chip
                        >
                        <v-chip
                            v-if="item.status === 0"
                            class="Grey white--text"
                            >Finalizado</v-chip
                        >
                    </template>
                </v-data-table>
                <!-----Tabla sin folder---->
            </v-card-text>
        </v-card>

        <v-dialog v-model="addtarea" max-width="700" persistent>
            <v-card>
                <v-card-title class="greenD white--text">
                    Nueva tarea <v-spacer></v-spacer>
                    <v-btn class="white" @click="addtarea = false">
                        <v-icon class="greenD--text">mdi-close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <br />
                    <v-text-field
                        v-if="proyectoSelect.adminproy"
                        label="Nombre de la Tarea"
                        outlined
                        v-model="addservice.titulo"
                    ></v-text-field>
                    <v-banner v-if="!proyectoSelect.adminproy"
                        ><b>{{ addservice.titulo }}</b></v-banner
                    >

                    <v-textarea
                        v-if="proyectoSelect.adminproy"
                        label="Sinopsis"
                        outlined
                        v-model="addservice.desc"
                    >
                    </v-textarea>

                    <v-text-field
                        type="date"
                        v-model="addservice.caducidad"
                        label="Fecha de Caducidad"
                    ></v-text-field>

                    <hr />
                    <label>Selecciona el Folder</label>

                    <v-select
                        v-model="addservice.folder"
                        v-if="proyectoSelect.adminproy === true"
                        label="Carpeta"
                        outlined
                        :items="listcarpetas"
                    >
                    </v-select>

                    <v-banner v-if="!proyectoSelect.adminproy">{{
                        addservice.desc
                    }}</v-banner>
                    <br /><br />

                    <v-row v-if="addservice.action === 'editar'">
                        <v-col cols="12" md="10">
                            <v-text-field
                                v-model="AddObs"
                                outlined
                                label="Agregar observaciones a tarea"
                            >
                            </v-text-field>
                            <v-chip
                                class="red white--text"
                                v-if="mensajeobstext"
                                >{{ mensajeobstext }}</v-chip
                            >
                        </v-col>
                        <v-col cols="12" md="2">
                            <v-btn
                                class="greenD"
                                v-if="AddObs.length > 0"
                                @click="addtextobs()"
                            >
                                <v-icon class="white--text"
                                    >mdi-content-save-plus</v-icon
                                >
                            </v-btn>
                        </v-col>
                        <v-col cols="12" md="12">
                            <v-spacer></v-spacer>
                            <v-btn class="greenD" @click="notasfull = true">
                                <v-icon class="white--text"
                                    >mdi-fullscreen</v-icon
                                >
                            </v-btn>
                            <v-dialog v-model="notasfull" fullscreen persistent>
                                <v-card>
                                    <v-card-title class="greenD white--text">
                                        Notas <v-spacer></v-spacer>
                                        <v-btn
                                            class="white"
                                            @click="notasfull = false"
                                        >
                                            <v-icon class="greenD--text"
                                                >mdi-close</v-icon
                                            >
                                        </v-btn>
                                    </v-card-title>
                                    <v-card-text>
                                        <v-text-field
                                            v-model="search"
                                            label="Ingrese a palabra o frase que desea buscar"
                                        ></v-text-field>
                                        <v-data-table
                                            :headers="notastitulo"
                                            :items="addservice.obs"
                                            :search="search"
                                        >
                                            <template
                                                v-slot:item.action="{ item }"
                                            >
                                                <v-btn
                                                    v-if="
                                                        proyectoSelect.adminproy
                                                    "
                                                    @click="
                                                        eliminaObservacion(item)
                                                    "
                                                    class="greenD white--text"
                                                >
                                                    <v-icon>mdi-delete</v-icon>
                                                </v-btn>
                                            </template>
                                        </v-data-table>
                                    </v-card-text>
                                </v-card>
                            </v-dialog>

                            <div
                                style="
                                    width: 100%;
                                    border: solid grey 1px;
                                    height: 80px;
                                    overflow: auto;
                                "
                            >
                                <!---<div  v-for="(key,index) in addservice.obs" :key="index+'obs'">
                            <v-list-item>
                                    <v-list-item-content >
                                    <v-list-item-title>{{key.fecha}} {{key.hora}} {{key.corre}}: {{key.contenido}}</v-list-item-title>
                                    </v-list-item-content>

                            </v-list-item>
                            <v-divider></v-divider>
                            </div>-->

                                <v-data-table
                                    :headers="notastitulomini"
                                    :items="addservice.obs"
                                    :search="search"
                                    hide-default-footer
                                >
                                    <template v-slot:item.action="{ item }">
                                        <v-btn
                                            v-if="proyectoSelect.adminproy"
                                            @click="eliminaObservacion(item)"
                                            class="greenD white--text"
                                        >
                                            <v-icon>mdi-delete</v-icon>
                                        </v-btn>
                                    </template>
                                </v-data-table>
                            </div>
                        </v-col>
                    </v-row>

                    <hr />

                    <v-select
                        v-if="proyectoSelect.adminproy"
                        v-model="addservice.asignado"
                        chips
                        label="Tarea asignada a:"
                        multiple
                        outlined
                        :items="userproy"
                    ></v-select>

                    <v-row v-if="proyectoSelect.adminproy">
                        <v-col cols="2"> </v-col>
                        <v-col cols="3">
                            <h5>Finalizado</h5>
                        </v-col>
                        <v-col cols="2">
                            <v-switch v-model="addservice.status"></v-switch>
                        </v-col>
                        <v-col cols="3">
                            <h5>En proceso</h5>
                        </v-col>
                    </v-row>

                    <v-progress-circular
                        v-if="stsave"
                        :width="4"
                        color="green"
                        indeterminate
                    ></v-progress-circular>
                    <v-chip color="greenD" v-if="stsave" class="white--text"
                        >Guardando Cambios espere un momento</v-chip
                    >

                    <v-btn
                        v-if="!stsave"
                        class="greenD white--text"
                        @click="GuardarTarea()"
                    >
                        <v-icon>mdi-content-save</v-icon>
                    </v-btn>

                    <v-btn
                        v-if="
                            proyectoSelect.adminproy &&
                            addservice.action === 'editar'
                        "
                        class="error white--text"
                        @click="eliminatarea(item)"
                    >
                        <v-icon>mdi-delete</v-icon>
                    </v-btn>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
import { mapState, mapMutation, mapActions } from "vuex";
export default {
    data() {
        return {
            tipoTareas: [
                { text: "Todo", value: null },
                { text: "Pendiente", value: 1 },
                { text: "Finalizado", value: 0 },
            ],
            filtros: false,
            mensajeobstext: "",
            addfolder: false,
            addtarea: false,
            addservice: {
                status: true,
            },
            update: true,
            stsave: false,
            AddObs: "",
            notasfull: false,
            searchgral: "",
            search: "",
            filstatus: null,
            taeasSelect: [],
            notastitulomini: [
                {
                    text: "Fecha",
                    value: "fecha",
                },
                {
                    text: "Hora",
                    value: "hora",
                },
                {
                    text: "Contenido",
                    value: "contenido",
                },
                {
                    text: "",
                    value: "action",
                },
            ],
            notastitulo: [
                {
                    text: "Fecha",
                    value: "fecha",
                },
                {
                    text: "Hora",
                    value: "hora",
                },
                {
                    text: "Correo",
                    value: "correo",
                },
                {
                    text: "Contenido",
                    value: "contenido",
                },
                {
                    text: "",
                    value: "action",
                },
            ],

            folders: [],
            folder: "",
            carpetas: [],
            listcarpetas: [],
            plantillaTareas: false,
            listaPlantillas: [],
        };
    },
    computed: {
        ...mapState([
            "tareas",
            "usuarios",
            "userproy",
            "proyectoSelect",
            "csrf",
            "sesion",
            "url",
            "socket",
            "moment",
        ]),
        titulotareas() {
            return [
                {
                    text: "Titulo",
                    value: "titulo",
                },
                {
                    text: "Status",
                    value: "status",
                    align: "left",
                    sortable: false,
                    filter: (value) => {
                        if (this.filstatus === null) {
                            return true;
                        } else {
                            return value === this.filstatus;
                        }
                    },
                },
                {
                    text: "Mis Tareas",
                    value: "asignado",
                },
                {
                    text: "Caducidad",
                    value: "caducidad",
                },
                {
                    text: "Editar",
                    value: "editar",
                },
            ];
        },
    },
    mounted() {
        this.cargaTareas();

        ///  console.log(this.socket)
        this.socket.on("actualizatarea", (data) => {
            console.log("Actualiza tarea");
            console.log(data);
            this.cargaTareas();
        });
    },
    methods: {
        ...mapActions(["loadTareas", "cambiaStatuSnackBar"]),
        onMoveCallback(event) {
            console.log(event);
        },
        onCloneCallback(event) {
            console.log(event);
        },
        onDropCallback(event) {
            console.log(event);
        },
        abreAddTareaPlantillas() {
            this.plantillaTareas === false
                ? (this.plantillaTareas = true)
                : (this.plantillaTareas = false);
            this.cargaListaPlantillas();
        },
        addTareasMutiples(){
            var payload={
                tareas:this.taeasSelect,
                id_proyecto:this.proyectoSelect.id
            }

            fetch(this.url+"altaMutipleTareas",{
                method: "POST",
                headers: {
                    "Content-type": "application/json",
                    "X-CSRF-TOKEN": this.csrf,
                },
                body:JSON.stringify(payload)
            })
            .then(res=>res.json())
            .then((res)=>{
                this.plantillaTareas=false
                this.taeasSelect=[]
                this. cargaTareas()

            })
        },
        cargaListaPlantillas() {
            fetch(this.url + "cargaplantillas", {
                method: "POST",
                headers: {
                    "Content-type": "application/json",
                    "X-CSRF-TOKEN": this.csrf,
                },
            })
                .then((res) => res.json())
                .then((res) => {
                    console.log(res)
                    this.listaPlantillas = res;
                });
        },
        validacaducidad(p) {
            var statuc = "greenD";
            if (p) {
                var fecha1 = new Date(p);
                var fecha2 = new Date(this.moment().format("YYYY-MM-DD"));

                if (fecha2 < fecha1) {
                    statuc = true;
                } else {
                    statuc = false;
                }
            }

            return statuc;
        },
        eliminatarea() {
            if (confirm("¿Seguro que deseas elimiar la tarea?")) {
                fetch(this.url + "eliminatarea", {
                    method: "POST",
                    headers: {
                        "Content-type": "application/json",
                        "X-CSRF-TOKEN": this.csrf,
                    },
                    body: JSON.stringify(this.addservice),
                })
                    .then((res) => res.json())
                    .then((res) => {
                        if (this.update === true) {
                            this.addtarea = false;
                        }
                        this.cargaTareas();
                        this.AddObs = "";
                        this.stsave = false;
                        var enviacambio = {
                            accion: "Elimina tarea",
                            id: this.proyectoSelect.id,
                        };
                        this.socket.emit("actualiza_tarea", enviacambio);
                    });
            }
        },
        minimizar() {
            this.$emit("minimizar", false);
        },
        addtextobs() {
            if (this.AddObs.length > 0) {
                this.update = false;

                var hoy = new Date();
                var fecha =
                    hoy.getDate() +
                    "-" +
                    (hoy.getMonth() + 1) +
                    "-" +
                    hoy.getFullYear();
                var hora =
                    hoy.getHours() +
                    ":" +
                    hoy.getMinutes() +
                    ":" +
                    hoy.getSeconds();
                this.addservice.obs.push({
                    fecha: fecha,
                    hora: hora,
                    correo: this.sesion.email,
                    contenido: this.AddObs,
                });
                this.GuardarTarea();
                this.update = true;
            } else {
                this.mensajeobstext = "Debe ingrear una observación";

                setTimeout(() => {
                    this.mensajeobstext = "";
                }, 3000);
            }
        },
        abreAddTarea() {
            this.addservice = {};
            this.addservice.action = "crear";
            this.addtarea = true;
            this.addservice.status = true;
            this.addservice.id_proyecto = this.proyectoSelect.id;
        },
        eliminaObservacion(p) {
            if (confirm("¿Seguro que desea eliminar la tarea seleccionada?")) {
                let arraymodif = this.addservice.obs.slice(
                    this.addservice.obs.indexOf(p)
                );
                this.addservice.obs = arraymodif;
                this.GuardarTarea();
            }
        },
        EditarTarea(item) {
            this.addtarea = true;

            this.addservice.action = "editar";
            this.addservice.id = item.id;
            this.addservice.id_proyecto = item.id_proyecto;
            this.addservice.titulo = item.titulo;
            this.addservice.id_proyecto = item.id_proyecto;
            this.addservice.obs = JSON.parse(item.obs);
            this.addservice.desc = item.desc;
            this.addservice.status = item.status;
            this.addservice.asignado = JSON.parse(item.asignado);

            this.addservice.obs.sort((a, b) => {
                if (a.fecha > b.fecha) {
                    return -1;
                }

                if (a.fecha < b.fecha) {
                    return 1;
                }

                if (a.fecha === b.fecha) {
                    if (a.hora > b.hora) {
                        return -1;
                    }

                    if (a.hora < b.hora) {
                        return 1;
                    }

                    return 0;
                }
            });

            console.log(this.addservice.obs);
        },

        GuardarTarea() {
            var error = [];
            var mensajes = "";

            if (!this.addservice.titulo) {
                error.push(
                    "Debe ingresar el <b>Titulo o Nombre de Tarea</b> para continuar"
                );
                mensajes +=
                    "Debe ingresar el <b>Titulo o Nombre de Tarea</b> para continuar<br />";
            }

            if (error.length > 0) {
                this.cambiaStatuSnackBar({
                    status: true,
                    text: mensajes,
                    color: "red",
                });
            } else {
                this.iniciaGuardado();
            }
        },
        iniciaGuardado() {
            this.stsave = true;
            this.addservice.proynombre = this.proyectoSelect.nombre;
            fetch(this.url + "registrotareas", {
                method: "POST",
                headers: {
                    "Content-type": "application/json",
                    "X-CSRF-TOKEN": this.csrf,
                },
                body: JSON.stringify(this.addservice),
            })
                .then((res) => res.json())
                .then((res) => {
                    if (this.update === true) {
                        this.addtarea = false;
                    }
                    this.cargaTareas();
                    this.AddObs = "";
                    this.stsave = false;
                    var enviacambio = {
                        accion: "update tarea",
                        id: this.proyectoSelect.id,
                    };
                    this.socket.emit("actualiza_tarea", enviacambio);
                });
        },
        cargaTareas() {
            this.loadTareas();
            this.cargacarpetas();
        },
        cargacarpetas() {
            var payload = {
                id_proyecto: this.proyectoSelect.id,
                tipo: "Tareas",
            };

            fetch(this.url + "cargafolder", {
                method: "POST",
                headers: {
                    "Content-type": "application/json",
                    "X-CSRF-TOKEN": this.csrf,
                },
                body: JSON.stringify(payload),
            })
                .then((res) => res.json())
                .then((res) => {
                    console.log(res);
                    this.folders = res.datos;
                    this.carpetas = res.status;

                    res.datos.map((pp) => {
                        this.listcarpetas.push(pp.nombre);
                    });
                    this.listcarpetas.push("");
                });
        },
        crearfolder() {
            var payload = {
                nombre: this.folder,
                id_proy: this.proyectoSelect.id,
                tipo: "Tareas",
            };

            fetch(this.url + "addfolder", {
                method: "POST",

                headers: {
                    "Content-type": "application/json",
                    "X-CSRF-TOKEN": this.csrf,
                },
                body: JSON.stringify(payload),
            })
                .then((res) => res.json())
                .then((res) => {
                    this.cargaTareas();
                    this.cargacarpetas();
                    this.addfolder = false;
                });
        },
        muestraCarpeta(n) {
            this.carpetas[n] === true
                ? (this.carpetas[n] = false)
                : (this.carpetas[n] = true);
        },
        eliminaCarpeta(id) {
            var payload = {
                id_folder: id,
            };
            fetch(this.url + "deletefolder", {
                method: "POST",

                headers: {
                    "Content-type": "application/json",
                    "X-CSRF-TOKEN": this.csrf,
                },
                body: JSON.stringify(payload),
            })
                .then((res) => res.json())
                .then((tres) => {
                    console.log(tres);
                    this.cargaTareas();
                    this.cargacarpetas();
                });
        },
        cambiarnombreCarpeta() {},
    },
};
</script>
