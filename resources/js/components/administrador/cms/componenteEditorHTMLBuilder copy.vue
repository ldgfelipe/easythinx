<template>
	<v-card>
		<v-card-title>
			Editor EasyThinx CMS
		</v-card-title>
		<v-card-text>

			<v-row>
				<v-col cols="12">
					



				</v-col>
				<v-col cols="3">
<v-tabs>
	<v-tab>
		Modulos
	</v-tab>
	<v-tab>
		Cuadricula
	</v-tab>
	<v-tab-item>
				<v-row>
					<v-col cols="5">
						

						<drag class="drag" :transfer-data="{ modulo:'button1'}">

							<v-card>
								<v-card-text>
									Boton 1
								</v-card-text>
							</v-card>

							<div slot="image" class="drag-image">
								modulo prueba
							</div>
						</drag>


					</v-col>
					

					<v-col cols="5">
						

						<drag class="drag" :transfer-data="{ modulo:'seccion1'}">

							<v-card>
								<v-card-text>
									Seccion 1
								</v-card-text>
							</v-card>

							<div slot="image" class="drag-image">
								modulo prueba
							</div>
						</drag>


					</v-col>

				</v-row>
			</v-tab-item>
			<v-tab-item>

				<v-row>

					<v-col cols="5">

						

							<v-card>
								<v-card-text>
									Grid 1 <v-btn class="greenD white--text" @click="addGrid('grid1')"><v-icon>mdi-plus</v-icon></v-btn>
								</v-card-text>
							</v-card>

						
						

					</v-col>
					<v-col cols="5">
						<v-card>
								<v-card-text>
									Grid 2 <v-btn class="greenD white--text" @click="addGrid('grid2')"><v-icon>mdi-plus</v-icon></v-btn>
								</v-card-text>
							</v-card>
					</v-col>


					<v-col cols="5">
						<v-card>
								<v-card-text>
									Grid 3 <v-btn class="greenD white--text" @click="addGrid('grid3')"><v-icon>mdi-plus</v-icon></v-btn>
								</v-card-text>
							</v-card>
					</v-col>
					<v-col cols="5">
						<v-card>
								<v-card-text>
									Grid 4 <v-btn class="greenD white--text" @click="addGrid('grid4')"><v-icon>mdi-plus</v-icon></v-btn>
								</v-card-text>
							</v-card>
					</v-col>
				</v-row>





			</v-tab-item>
</v-tabs>
				</v-col>
				<v-col cols="9">
					
					

					<v-btn class="greenD white--text" @click="editable===true ? editable=false : editable=true" >{{editable===false ? 'Editar' :  'Terminar'}}</v-btn> 


					<v-btn class="greenD white--text" @click="leercomponent()"> Ver HTML Code</v-btn>

<br />
<br />

		<div class="espacioeditor" ref="contenhtml" >
			<v-chip v-if="modulos.length===0">Agrege un componente
			</v-chip>
			<ul class="secciones"   >
				<li v-for="(key, index) in modulos" style="text-decoration: none;">
					
					<components  
						v-bind:is="key" 
						:editable="editable" 
						@openEditable="changeEditable($event)" 
						@closeEditable="changeEditable($event)" 
						:datainfo="configpage.modulos[key+index] ? configpage.modulos[key+index] : {}" 
						@updateConfigPage="saveConfigpage(key+'-'+index,$event)" 
					></components>
					
				</li>
			</ul>


		</div>
<br /><br />
				</v-col>

			</v-row>

			<v-dialog v-model="htmlcode" max-width="800">

				<v-card>
					<v-card-title>
						Codigo HTML
					</v-card-title>
					<v-card-text>
							<v-progress-circular
						      indeterminate
						      color="green"
						      v-if="!contenido"
						    ></v-progress-circular>
						    <div v-if="contenido">
						{{contenido}}
							</div>
					</v-card-text>
				</v-card>
			</v-dialog>

		</v-card-text>
	</v-card>
</template>
<style>


	</style>
<script>

	export default{
		data(){
			return {
				htmlcode:false,
				modulos:[],
				contenido:"",
				editable:false,
				configpage:{
					modulos:[],
					conmodule:{}
				}
			}
		},
		methods:{
			addGrid(data) {
					this.modulos.push(data)
			},
			leercomponent(){
				this.htmlcode=true
				this.editable=false
				setTimeout(()=>{
					console.log(this.$refs)
					this.contenido=this.$refs.contenhtml.innerHTML
				},1000)
				
			},
			saveConfigpage(nmodul,data){
						this.configpage.conmodule[nmodul]=data
						this.configpage.modulos=this.modulos

						
			},
			changeEditable(ch){
				this.editable=ch
			}
		}
	}
	</script>