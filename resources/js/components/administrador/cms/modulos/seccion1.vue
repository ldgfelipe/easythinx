<template>
	<div class="row">

		<div  @dblclick="openEditable()" v-html="data.contenido">
		
		</div>
	
			
<v-dialog v-model="editarmodulo" persistent max-width="1200">
	<v-card>
		<v-card-title>
			<v-spacer></v-spacer> 

			<v-btn class="greenD white--text" @click="closeEditable()"><v-icon>mdi-content-save</v-icon></v-btn>
 <v-btn class="greenD white--text" @click="editarmodulo=false"><v-icon>mdi-close</v-icon></v-btn>

		</v-card-title>

		<v-card-text>
					<vue-editor v-model="data.contenido" />
					<v-btn class="greenD white--text" @click="closeEditable()"><v-icon>mdi-content-save</v-icon></v-btn> <v-btn class="greenD white--text" @click="editarmodulo=false"><v-icon>mdi-close</v-icon></v-btn>
		</v-card-text>
	</v-card>
</v-dialog>

	</div>
</template>
<script>
export default{
	data(){
		return {
			data:{},
			editar:false,
			editarmodulo:false
		}
	},
	created(){
		Object.keys(this.datainfo).length > 0 ? this.data=this.datainfo : this.data={
			contenido:"texto de prueba"
		}
	},
	methods:{
			openEditable(){
				//this.editar=true
				//this.$emit('openEditable',true)
				this.editarmodulo=true

			},
			closeEditable(){
				this.editar=false
				this.editarmodulo=false
				//this.$emit('closeEditable',false)
				this.$emit('savedata',this.data);
			}
	},
	props:{
		editable:{
			default:false
		},
		datainfo:{
			type:[Object,Array],
			default:{}
		}
	},
	watch:{
		editable(){
			this.editar=this.editable
		}
	}
}
</script>