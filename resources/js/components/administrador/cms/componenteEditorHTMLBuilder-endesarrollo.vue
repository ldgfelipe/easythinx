<template>
	<v-card>
		<v-card-title>
			Editor EasyThinx CMS
		</v-card-title>
		<v-card-text>

			<v-row>
				<v-col cols="12">
					herramientas

				</v-col>
				<v-col cols="3">




				<drag class="drag" :transfer-data="{ modulo:   `
				<div class='col-md-6 sectext' onclick='htmlcode=true' contenteditable='true' id='textoediter' >texto</div>
				<div>`}">

					<v-card>
						<v-card-text>
							<v-row >
								<v-col cols="2" style="border:1px #000 solid;"  >

									<v-icon>mdi-file-image</v-icon>

								</v-col>
								<v-col cols="4" style="border:1px #000 solid;">

									<v-icon>mdi-card-text</v-icon>
								
								</v-col>
							</v-row>
						</v-card-text>
					</v-card>

					<div slot="image" class="drag-image">
						modulo prueba
					</div>
				</drag>





				</v-col>
				<v-col cols="9">
					
					


		<drop class="drop" @drop="handleDrop">
			<div class="espacioeditor" v-html="contenido">

			</div>

			<v-btn class="greenD white--text" @click="htmlcode=true"> Ver HTML Code</v-btn>
		

		</drop>



				</v-col>

			</v-row>

			<v-dialog v-model="htmlcode" max-width="800">

				<v-card>
					<v-card-title>
						Codigo HTML
					</v-card-title>
					<v-card-text>
						{{contenido}}
					</v-card-text>
				</v-card>
			</v-dialog>

		</v-card-text>
	</v-card>
</template>
<style>
.espacioeditor{
	width: 100%;
	max-width: 100%;
	height: 100%;
	border: solid 1px #000;
}


	</style>
<script>

	export default{
		data(){
			return {
				contenido:"",
				htmlcode:false
			}
		},
		methods:{
				handleDrop(data) {
			this.contenido=this.contenido+''+data.modulo
			},
			leercomponent(){
				console.log(this.content)
			}
		},
	watch:{
		contenido(){

			console.log(document.getElementById('textoediter'))

		}
	}
	}
	</script>