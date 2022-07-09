<template>
    <div class="areadash">
        <v-row>
            <v-col cols="12" md="8">
                <componenteproyectos></componenteproyectos> 
            </v-col>
                <v-col cols="12" md="4"></v-col>
            <v-col cols="12" md="4" class="tabledata">
             <componentetareas></componentetareas>
            </v-col>
             <v-col cols="12" md="4" class="tabledata">
                <componentearchivos></componentearchivos>
            </v-col>
             <v-col cols="12" md="4" class="tabledata">
                <componentechat></componentechat>
            </v-col>
        </v-row>
       
    </div>
</template>
<style>


.areadash{
    padding:15px;
}

.tabledata{
    height: 90%;
 
}

</style>

<script>

    export default {

       

    }
</script>
