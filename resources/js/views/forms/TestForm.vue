<template>
  <div>

    <w-divider class="my6 my-1"></w-divider>
    {{ image }}
    <w-divider class="my6 my-1"></w-divider>
    <BaseInput :label="'Caption'" :showLabel="false" v-model="form.caption" />
    <file-pond 

    name="imageFilePond"
    ref="pond"
    :allow-multiple="false"
    accepted-file-types="image/*"
    v-bind:server="{
        url: '',
        timeout: 7000,
        process: {
            url: '/api/image/upload-local',
            method: 'POST',
            withCredentials: true,
            headers: {
              Authorization: 'Bearer ' + authtoken,
            },
            onload: handleFilePondLoad,
            onerror: ()=>{}
            
        },
        remove:  handleFilePondRemove
    }"
    v-bind:files="myFiles" 
    v-on:init="handleFilePondInit"


    
    /> 
  </div>
</template>

<script>
import BaseInput from "../../components/BaseInput.vue";

import vueFilePond from "vue-filepond";

// Import plugins
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js";
import FilePondPluginImagePreview from "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js";
import FilePondPluginFilePoster from "filepond-plugin-file-poster";

// Import styles
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

// Create FilePond component
const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview,
  FilePondPluginFilePoster
);

export default {
  components: {
    FilePond,
    BaseInput,
  },

  created () {
    this.authtoken = localStorage.getItem("token");
  },

  data() {
    return {
    authtoken: null,
    image: null,
      form: {
        caption: "",
        myFiles: [],
      },
    };
  },
  methods: {
    image_path(image){
        return '/'+ image;
    },

    handleFilePondInit() {

        if(this.image){
            this.form.myFiles = [{
                source: '/'+ this.image,
                    options: {
                        type:'local',
                        metadata: {
                            poster: '/'+ this.image  
                        }
                    }
                }
            ];
        }else{
            this.form.myFiles =[]; 
        }

    },

    handleFilePondLoad(response) {
        this.image = response;
    },

    handleFilePondRemove(source , load , error){
        this.image = '';
        load();
    },
    handleFilePondRever(uniquid, load,  error){
        axios.post('/api/image/upload-local');
    }
  },
};
</script>

<style scoped></style>
