

<!-- revert: {
    url: '/api/image/upload/revert',
    methods: 'DELETE',
    withCredentials: true,
    headers:{
        'Authorization': 'Bearer '+ authtoken
    },
    
} -->

<template>
    <div>{{ filetype }}</div>
    <div>{{ uploadType }}</div>
    
    <file-pond
    name="files"   
    class="filepond"
    ref="pond"
    :accepted-file-types="filetype" 
    :allow-multiple="uploadType"  
    :server="{
        
        url: '',
        timeout: 7000,
        process: {
            url: '/api/image/upload/local',
            timeout: 7000,
            methods: 'POST',
            withCredentials: true,
            headers:{
                'Authorization': 'Bearer '+ authtoken
            },
            onload: handleFilePondLoad,           
            onerror: ()=>{}
        },
        revert: handleFilePondRevert
    }"

    :files="files"

    @init="handleFilePondInit"
    @activatefile="handeFilePondActive"
    @processFiles="handleFilePondProcessFiles"
    >

    </file-pond>
    
</template>
<script>



import axiosApi from '../api/axiosApi';

import vueFilePond from 'vue-filepond';

    // Import plugins
    import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js';
    import FilePondPluginImagePreview from 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js';
    import FilePondPluginFilePoster from 'filepond-plugin-file-poster';
    import FilePondPluginImageCrop from 'filepond-plugin-image-crop';

    // Import styles
    import 'filepond/dist/filepond.min.css';
    import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';
    

    // Create FilePond component
    const FilePond = vueFilePond(
        
        FilePondPluginImageCrop,
        FilePondPluginFileValidateType,
        FilePondPluginImagePreview,
        FilePondPluginFilePoster);

    export default {

        props: {
            passFiles: {
                type: Array,
                default: [],
            },

            filetype: {
                type:  String,
                required:false,
                default: 'image/jpeg, image/png',
            },
            
            uploadType: {
                type: Boolean,
                default: false
            }
        },
        
        emits: ["successUpload"],


        created () {

            this.authtoken = localStorage.getItem('token');
 
            if(this.passFiles.id !=  null){
                    
                // this.files = this.passFile
                console.log('has data passed');

            }else{
                console.log('no data passed');
            }
            
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
                files:  []
            }
        },        

        methods: {
            handleFilePondProcessFiles(){
                console.log('success');
            },

            handeFilePondActive(file){
                // console.log(file.filename);
                // console.log(file.serverId);
            },
        
            handleFilePondInit(){
                // console.log('initialise');
            },

            handleFilePondLoad(response){
                return response;
                // console.log(response);
                // this.$emit('successUpload', response);
                // this.files.push(response);
            },

            handleFilePondError(response){
                console.log(response);
            },

        
             
            handleFilePondRevert(uniquid, load , error){
                console.log(uniquid);
                axiosApi.delete('api/image/upload/revert', {
                   data: {
                    folder: uniquid 
                   }
                }).then(res=>{
                    console.log(res);
                });

                load();
            }   

         
           
        }
    }
</script>

<style scoped>
.filepond--root {
    max-width:20em;
}

.filepond--item {
    width: calc(50% - 0.5em);
}


@media (min-width: 30em) {
    .filepond--item {
        width: calc(50% - 0.5em);
    }
}

@media (min-width: 50em) {
    .filepond--item {
        width: calc(33.33% - 0.5em);
    }
}


</style>