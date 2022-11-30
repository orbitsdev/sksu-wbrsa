

<template>
    <file-pond 
    :files="myFiles" 
    /> 

</template>

<script>

import vueFilePond from 'vue-filepond';

// Import plugins
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js';
import FilePondPluginFilePoster from "filepond-plugin-file-poster";

// Import styles
import 'filepond/dist/filepond.min.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';

// Create FilePond component
const FilePond = vueFilePond(
    FilePondPluginFileValidateType, 
    FilePondPluginImagePreview,
    FilePondPluginFilePoster
    );
    export default {
    
        components: {
            FilePond,
        },
        data() {
            return {
                myFiles: []
            }
        },

    methods: {
        handleFilePondInit(){
            
        },

        handleFilePondLoad(){

        }
    }
        
    }
</script>

<style scoped>

</style>