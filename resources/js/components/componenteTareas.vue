<template>
<div>
<v-card>
    <v-card-title class="greenD white--text">
        Tareas <v-spacer></v-spacer>  <v-btn class="white greenD--text"><v-icon>mdi-plus</v-icon></v-btn>
    </v-card-title>
    <v-card-text>
        Carga tareas
    </v-card-text>
</v-card>


    <v-dialog v-model="dialog" max-width="700">
        <v-card>
            <v-card-title>
                Nueva tarea
            </v-card-title>
            <v-card-text>
                <v-text-field label="Nombre de Servicio" v-model="addservice.nombre" ></v-text-field>
                <v-text-field label="Sinopsis" v-model="addservice.sinopsis" ></v-text-field>
                <v-text-field label="Descripción" v-model="addservice.desc" ></v-text-field>
                <v-btn class="greenD">Guardar</v-btn>
            </v-card-text>
        </v-card>

    </v-dialog>

</div>
</template>
<script>
export default{
data(){
    return {
        dialog:false,
        addservice:{}
    }
}

}
</script>