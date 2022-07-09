<template>
<div>
<v-card>
    <v-card-title class="greenD white--text">
        Archivos <v-spacer></v-spacer>  <v-btn class="white greenD--text"><v-icon>mdi-plus</v-icon></v-btn>
    </v-card-title>
    <v-card-text>
       Carga archivos
    </v-card-text>
</v-card>


    <v-dialog v-model="dialog" max-width="700">
        <v-card>
            <v-card-title>
                Nueva Archivo
            </v-card-title>
            <v-card-text>
                <v-text-field label="Nombre de Archivo" v-model="addfile.nombre" ></v-text-field>
            
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
        addfile:{}
    }
}
}
</script>