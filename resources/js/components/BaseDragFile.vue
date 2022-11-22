




<template>

    <file-pond
    name="imageFilepond"
    ref="pond"
    :allow-multiple="false"
    accepted-file--types="image/png, image/jpeg"
    :server="{
        url: '',
        process: {
            url: 'api/upload/school',
            timeout: 7000,
            methods: 'POST',
            withCredentials: true,
            headers:{
                'Authorization': 'Bearer '+authtoken
            },
            onLoad: handleFilePondLoad,
            onerror: ()=> {},

        }
        
    }"
    :file="myFile"
    @init="handleFilePondInit"
    >

    </file-pond>
    
</template>
<script>


const token = localStorage.getItem('token');

import vueFilePond from 'vue-filepond';

    // Import plugins
    import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js';
    import FilePondPluginImagePreview from 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js';
    import FilePondPluginFilePoster from 'filepond-plugin-file-poster';
    // Import styles
    import 'filepond/dist/filepond.min.css';
    import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';
    

    // Create FilePond component
    const FilePond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginImagePreview, FilePondPluginFilePoster);


    export default {

        created () {
            this.authtoken = localStorage.getItem('token');
            console.log(this.authtoken);
        },
        mounted() {

            // console.log(token);
        },
        components: {
            FilePond ,
        },
        data() {
            return {
                authtoken: null,
                myFile:  []
            }
        },        

        methods: {
            handleFilePondInit(){
                console.log('File Pond Initalize');
            },
             
            handleFilePondLoad(response){
                console.log(response);
            },
            handleError(err){
                console.log(err);
            }
        }
    }
</script>

<style scoped>


</style>