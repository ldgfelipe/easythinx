<template>
	<v-card>
		<v-card-text>


			<v-text-field placeholder="Buscar Usuario" outlined v-model="search"></v-text-field>


			<v-data-table :search="search" :headers="titleuser" :items="usuarios">

				<template v-slot:item.tipo_usuario="{ item }">
				<v-chip v-if="item.tipo_usuario===2">Super Admin</v-chip>
				<v-chip v-if="item.tipo_usuario===1">Admin Proyect</v-chip>
				<v-chip v-if="item.tipo_usuario===0">Colaborador</v-chip>
				</template>

				<template v-slot:item.action="{ item }" >
					<v-btn class="greenD white--text" @click="editaUsuario(item)"><v-icon>mdi-cog-outline</v-icon></v-btn>
				</template>


			</v-data-table>


			<v-dialog max-width="600" v-model="editauser">
				<v-card>
					<v-card-title class="greenD white--text">
							Administrar Usuario <v-spacer></v-spacer> <v-btn @click="editauser=false" class="white greenD--text"><v-icon>mdi-close</v-icon></v-btn>
					</v-card-title>
					<v-card-text>
						<hr />
						<v-row>
							<v-col cols="6">
								<v-text-field v-model="adminuser.name" outlined placeholder="Nombre" />
								<v-text-field v-model="adminuser.email" outlined placeholder="Corre" />
								<v-text-field v-model="adminuser.email_verified_at" outlined placeholder="Correo verificado" readonly />

							</v-col>
							<v-col cols="6">
								<v-select outlined v-model="adminuser.tipo_usuario" placeholder="Tipo de Usuario" :items="[
									{
										text:'Super Usuario',
										value:2
									},
									{
										text:'Administrador de Proyecto',
										value:1
									},
									{
										text:'Colaborador',
										value:0
									}
								]"

								item-text="text"
								item-value="value"

								 ></v-select>

								 <hr />
								 {{adminuser.created_at}}
								 <hr />
								 {{adminuser.updated_at}}
							</v-col>
							<v-col cols="12">
								<v-btn class="greenD white--text" @click="GuardarUsuario()">Guardar</v-btn>
							</v-col>
						</v-row>
					</v-card-text>
				</v-card>
			</v-dialog>

		</v-card-text>
	</v-card>
</template>
<script>

export default {
	data(){
		return {

			titleuser:[
				{
					text:'Nombre',
					value:'name'
				},
				{
					text:'Correo',
					value:'email'
				},
				{
					text:'Correo Verificado',
					value:'email_verified_at'
				},
				{
					text:'Tipode Usuario',
					value:'tipo_usuario'
				},
				{
					text:"Action",
					value:"action"
				}
			],
			usuarios:[],
			adminuser:{},
			editauser:false,
			search:""
		}
	},
	created(){
		this.cargaUsuarios()
	},
	methods:{
		editaUsuario(p){
			this.adminuser=p
			this.editauser=true
		},
		cargaUsuarios(){
			var payload={
				carga:'Carga Datos de Usuario'
			}

			fetch(this.url+'cargausuariosadmin',{
                method:'POST',
                headers:{
                    'Content-type':'application/json',
                    'X-CSRF-TOKEN':this.csrf
                },
                body:JSON.stringify(this.payload)
			})
			.then(res=>res.json())
			.then((res)=>{
				console.log(res)
				this.usuarios=res
			})

		},
		GuardarUsuario(){
			fetch(this.url+'cambiosusuario',{
				method:'POST',
				headers:{
					 'Content-type':'application/json',
                    'X-CSRF-TOKEN':this.csrf
				},
				body:JSON.stringify(this.adminuser)
			})
			.then(res=>res.json())
			.then((res)=>{
                this.editauser=false
                this.adminuser={}
				console.log(res)
			})
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
