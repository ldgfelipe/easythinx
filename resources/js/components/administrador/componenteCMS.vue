<template>
<v-card>

	<v-card-title>
		<v-spacer></v-spacer>

		<v-menu

      offset-y
    >
      <template v-slot:activator="{ attrs, on }">
        <v-btn
          color="greenD"
          class="white--text ma-5"
          v-bind="attrs"
          v-on="on"
        >
        Menú
        </v-btn>
      </template>

      <v-list>
        <v-list-item
          v-for="(item, index) in items"
          :key="index+''+item"
          link
        >
          <v-list-item-title v-text="item.title" @click="cambiacomponente(item.componente)"></v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>


	</v-card-title>

	<v-card-text>

	
		<component v-bind:is="componente"></component>

	</v-card-text>
</v-card>
</template>

<script>
export default {
    data() {

	    return {
		      items: [
		        { title: 'Paginas', componente:'paginas' },
		        { title: 'Menus', componente:'menus' },
		        { title: 'Cabecera', componente:'cabecera' },
		        { title: 'Pie de Pagina', componente:'piedepagina' },
		        { title:'Redes Sociales', componente:'redessociales'}
		      ],
		      componente:"paginas"
	    	}
		},

	methods:{
		cambiacomponente(p){

			this.componente=p

		}	
	}
    
}
</script>