<template>
    <v-card>
        <v-card-title> Administración de Plantillas </v-card-title>
        <v-card-text>
            <v-btn class="greenD white--text" @click="addplan = true">Crear nueva plantilla
                <v-icon>mdi-plus</v-icon></v-btn>

            <v-data-table :headers="header" :items="loplant">

                <template v-slot:item.action="{ item }">
                    <v-btn class="greenD white--text"
                        @click="eliminarPlantilla(item.id)"><v-icon>mdi-close</v-icon></v-btn>
                </template>

                <template v-slot:item.tareas="{ item }">
                    Total de Tareas: <span v-if="item.tareas"> {{ !item.tareas === '' ? 0 : typeof item.tareas ===
                        'string' ? JSON.parse(item.tareas).length : item.tareas.length }} </span>
                    <v-btn class="greenD white--text" @click="addtareas(item)"
                        title="Agregar Tareas a la plantilla">Editar Tareas</v-btn>
                </template>
            </v-data-table>

            <!----add tares--->
            <v-dialog v-model="viewaddtareas" fullscreen persistent>
                <v-card>
                    <v-card-title class="greenD white--text">
                        Listado de tareas de plantilla {{ itemSelect.nombre }}
                        <v-spacer></v-spacer>
                        <v-btn @click="viewaddtareas = false"
                            class="white greenD--text"><v-icon>mdi-close</v-icon></v-btn>
                    </v-card-title>
                    <v-card-text><br />
                        <v-row>
                            <v-col cols="9" md="9">
                                <v-text-field outlined v-model="titulotarea"
                                    label="Ingrese el nombre de la tarea"></v-text-field>
                            </v-col>
                            <v-col cols="3" md="3">
                                <v-btn class="greenD white--text"
                                    @click="GuardarTareas()"><v-icon>mdi-plus</v-icon></v-btn> <v-btn
                                    class="greenD white--text" @click="GuardarCambiosPlantilla()">Guardar
                                    Cambios</v-btn>
                            </v-col>
                            <v-col cols="12" md="12">
                                <v-data-table :headers="tareasTitulos" :items="itemSelect.tareas">

                                    <template v-slot:item="{ item, index }">
                                        <tr :draggable="true" @dragstart="dragStart(index)" @dragover.prevent
                                            @drop="drop(index)" @dragenter="dragEnter(index)" @dragleave="dragLeave"
                                            :class="{ dragging: dragIndex === index }">
                                            <td>
                                                <v-row>
                                                    <v-col cols="1" style="font-size:18px;">
                                                {{ index + 1 }}.-
                                                    </v-col>
                                                    <v-col  cols="11">
                                                        <v-text-field v-model="item.tarea"></v-text-field>
                                                    </v-col>
                                                </v-row>
                                            </td>
                                            <td>
                                                <v-btn class="red white--text"
                                                    @click="eliminaTarea(item)"><v-icon>mdi-delete</v-icon></v-btn>

                                            </td>

                                        </tr>
                                    </template>
                                </v-data-table>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-dialog>

            <!----add tares--->

            <!----ventana paga crear plantillas----->
            <v-dialog v-model="addplan" max-width="500" persistent>
                <v-card>
                    <v-card-title>
                        Nueva Plantilla <v-spacer></v-spacer>
                        <v-btn class="greenD white--text" @click="addplan = false"><v-icon>mdi-close</v-icon></v-btn>
                    </v-card-title>
                    <v-card-text>
                        <v-text-field v-model="addplantilla.nombre"></v-text-field>
                        <v-btn class="greenD white-text" @click="GuardarPlantila()">Guardar</v-btn>
                    </v-card-text>
                </v-card>
            </v-dialog>
            <!----ventana paga crear plantillas----->
        </v-card-text>
    </v-card>
</template>
<script>
import { mapState, mapActions, mapMutations } from "vuex";
export default {
    data() {
        return {
            addplan: false,
            addplantilla: {
                nombre: "",
            },
            tareasTitulos: [
                {
                    text: "Tarea",
                    value: "tarea"
                },
                {
                    text: "Eliminar",
                    value: "eliminar"
                }
            ],
            header: [
                {
                    text: "Nombre",
                    value: "nombre",
                },
                {
                    text: "Tareas",
                    value: "tareas",
                },
                {
                    text: "Acciones",
                    value: "action",
                },
            ],
            loplant: [],
            viewaddtareas: false,
            itemSelect: [],
            titulotarea: "",
            dragIndex: null
        };
    },
    mounted() {
        this.CargaPantillas();
    },
    computed: {
        ...mapState(["url", "csrf"]),
    },
    methods: {
        GuardarTareas() {
            this.itemSelect.tareas.push({
                tarea: this.titulotarea
            })

            this.titulotarea = ""
        },
        addtareas(item) {
            this.viewaddtareas = true;

            this.itemSelect = item;
            if (this.itemSelect.tareas === "") {
                this.itemSelect.tareas = []
            } else {
                this.itemSelect.tareas = JSON.parse(this.itemSelect.tareas)
            }
        },
        eliminarPlantilla(item) {

            if (confirm('¿Desea eliminar esta plantilla?')) {

                let payload = {
                    id: item
                }
                fetch(this.url + 'eliminaplantilla', {
                    method: 'POST',
                    headers: {
                        'Content-type': 'application/json',
                        'X-CSRF-TOKEN': this.csrf
                    },
                    body: JSON.stringify(payload)
                })
                    .then(res => res.json())
                    .then((res) => {
                        console.log(res)
                        this.CargaPantillas()
                    })

            }

        },
        CargaPantillas() {
            let payload = {
                load: "plantllas",
            };
            fetch(this.url + "cargaplantillas", {
                method: "POST",
                headers: {
                    "Content-type": "application/json",
                    "X-CSRF-TOKEN": this.csrf,
                },
                body: JSON.stringify(payload),
            })
                .then((res) => res.json())
                .then((res) => {
                    this.loplant = res;
                });
        },
        GuardarPlantila() {
            fetch(this.url + "addplantilla", {
                method: "POST",
                headers: {
                    "Content-type": "application/json",
                    "X-CSRF-TOKEN": this.csrf,
                },
                body: JSON.stringify(this.addplantilla),
            })
                .then((res) => res.json())
                .then((res) => {
                    this.addplan = false;
                    this.addplantilla.nombre = ""
                    this.CargaPantillas()
                });
        },
        GuardarCambiosPlantilla() {

            fetch(this.url + "guardacambioasplantilla", {
                method: "POST",
                headers: {
                    "Content-type": "application/json",
                    "X-CSRF-TOKEN": this.csrf,
                },
                body: JSON.stringify(this.itemSelect)
            })
                .then(res => res.json())
                .then((res) => {
                    this.viewaddtareas = false
                })
        },
        eliminaTarea(item) {
            this.itemSelect.tareas.splice(this.itemSelect.tareas.indexOf(item), 1)
        },
        /// area de arraste 
        dragStart(index) {
            this.dragIndex = index;
        },
        dragEnter(index) {
            // Opcional: Añadir estilos al arrastrar sobre una fila
        },
        dragLeave() {
            // Opcional: Remover estilos al salir de una fila
        },
        drop(index) {
            const draggedItem = this.itemSelect.tareas[this.dragIndex];
            this.itemSelect.tareas.splice(this.dragIndex, 1); // Remover el elemento arrastrado
            this.itemSelect.tareas.splice(index, 0, draggedItem); // Insertar en la nueva posición
            this.dragIndex = null; // Resetear el índice de arrastre
        },
    },
};
</script>
<style scoped>
.dragging {
  background-color: #e3f2fd;
  cursor:grab;
}
</style>