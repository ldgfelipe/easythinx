<template>
<div class="row">
	<div class="col-md-12">
		<drop class="drop espacioeditor" @drop="handleDrop" >
			<v-chip v-if="modulos.length===0">Agrege un componente
			</v-chip>
			<ul class="secciones" >
				<li v-for="(key, index) in modulos" style="text-decoration: none;">
					
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
				modulos:[],
				contenido:"",
				configpage:{
					modulos:[],
					conmodule:{}
				}
		}
	},
	methods:{
		handleDrop(data) {
					this.modulos.push(data.modulo)
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
