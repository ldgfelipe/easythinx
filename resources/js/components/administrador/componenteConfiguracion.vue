<template>
	<v-card>
		<v-card-title class="greenD white--text">

				Datos de Configuración <v-spacer></v-spacer>  

					<v-menu offset-y >
					      <template v-slot:activator="{ attrs, on }">
					        <v-btn
					          color="white"
					          class="greenD--text ma-5"
					          v-bind="attrs"
					          v-on="on"
					        >
					        Menú
					        </v-btn>
					      </template>

					      <v-list>
					        <v-list-item
					          v-for="(item, index) in itemsMenu"
					          :key="index+''+item"
					          link
					        >
					          <v-list-item-title v-text="item.title" @click="cambiacomponente(item.componente)"></v-list-item-title>
					        </v-list-item>
					      </v-list>
					    </v-menu>
		</v-card-title>
		<v-card-text>

			<component 
				v-bind:is="componente"
				:csrf="csrf"
                :url="url"
                :websocket="websocket"
                :sesion="sesion"
                :idproy="idproy"
			></component>
		
		</v-card-text>

	</v-card>
</template>
<script>
	export default{
		data(){
			return {
				componente:"usuarios",
				itemsMenu:[
					 { title: 'Usuarios', componente:'usuarios' },
				]
			}
		},
		methods:{
			cambiacomponente(item){
				this.componente=item
			}
		},
		props:{
			csrf: "",
	        url: "",
	        websocket: "",
	        sesion: {},
	        idproy: "",
		}
	}


</script>