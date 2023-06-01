<template>
<div class="row">
	<div class="col-md-4">
		<drop class="drop espacioeditor" @drop="handleDrop($event,0)" >
			<v-chip v-if="modulos.length===0">Agrege un componente
			</v-chip>
			<ul class="secciones" >
				<li v-for="(key, index) in modulos.col0" style="text-decoration: none;">
					
					<components  v-bind:is="key" :editable="editable" @openEditable="changeEditable($event)" @closeEditable="changeEditable($event)" :datainfo="configpage.modulos[key+index] ? configpage.modulos[key+index] : {}" @savedata="saveConfigpage(key+index,$event)" >
					</components>
					
				</li>
			</ul>


		</drop>
	</div>
	<div class="col-md-4">
		<drop class="drop espacioeditor" @drop="handleDrop($event,1)" >
			<v-chip v-if="modulos.length===0">Agrege un componente
			</v-chip>
			<ul class="secciones" >
				<li v-for="(key, index) in modulos.col1" style="text-decoration: none;">
					
					<components  v-bind:is="key" :editable="editable" @openEditable="changeEditable($event)" @closeEditable="changeEditable($event)" :datainfo="configpage.modulos[key+index] ? configpage.modulos[key+index] : {}" @savedata="saveConfigpage(key+index,$event)" >
					</components>
					
				</li>
			</ul>


		</drop>
	</div>
	<div class="col-md-4">
		<drop class="drop espacioeditor" @drop="handleDrop($event,2)" >
			<v-chip v-if="modulos.length===0">Agrege un componente
			</v-chip>
			<ul class="secciones" >
				<li v-for="(key, index) in modulos.col2" style="text-decoration: none;">
					
					<components  v-bind:is="key" :editable="editable" @openEditable="changeEditable($event)" @closeEditable="changeEditable($event)" :datainfo="configpage.modulos[key+index] ? configpage.modulos[key+index] : {}" @savedata="saveConfigpage(key+index,$event)" >
					</components>
					
				</li>
			</ul>


		</drop>
	</div>
</div>
</template>
<script>
export default {
	data(){
		return {
			htmlcode:false,
				modulos:{
					col0:[],
					col1:[],
					col2:[]
				},
				contenido:"",
				configpage:{
					modulos:[],
					conmodule:{}
				}
		}
	},
	methods:{
		handleDrop(data,columna) {
			
			this.modulos['col'+columna].push(data.modulo)

			},
		saveConfigpage(nmodul,data){
						this.configpage.conmodule[nmodul]=data
						this.configpage.modulos=this.modulos
						this.$emit('updateConfigPage',this.configpage)				
			},
	},

	props:{
		editable:{
			default:false
		}
	},
}

	</script>
