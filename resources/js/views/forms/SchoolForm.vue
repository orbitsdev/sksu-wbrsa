<template>
  <w-card class="cs" content-class="pa0">


      {{ passData }}
    <BaseInput label="School Name" :showLabel="false"  v-model="form.name" :error="error.name"/>
    <BaseInput label="Schol Address"  :showLabel="false" v-model="form.address" :error="error.address"/>

    <div class="inp mb-3">
      <DragAndDropFiles @successUpload="setSchoolImage" />
    </div>

    <div class="action mt-3">
      <CustomButton class="mr-2" @click="this.$emit('close')"> Close</CustomButton>
      <BaseSpinner v-if="isLoading" />
      <CustomButton v-else type="submit" @click="submitForm"> Save</CustomButton>
    </div>

  </w-card>
</template>

<script>

import CustomButton from "../../components/CustomButton.vue";
import BaseSpinner from "../../components/BaseSpinner.vue";
import axiosApi from "../../api/axiosApi";
import DragAndDropFiles from '../../components/DragAndDropFiles.vue';
import BaseInput from '../../components/BaseInput.vue';

export default {
  components: {
    CustomButton,
    BaseSpinner,
    DragAndDropFiles,
    BaseInput,

  },
  emits: ["close", "hasError"],


  

    props: {
      passData: {
        type: Object,
        default: {},
      },
    },

created () {

  if(this.passData != null){
    this.form = this.passData;
  }
  
},

  data() {
    return {
      isLoading: false,
      error: {},
      requestError: null,
      selectedData: null,
      form: {
        name: "",
        address: "",
        files: []
      },
      validators: {
        required: (value) => !!value || "This field is required",
      },
    };
  },



  methods: {

    

    setSchoolImage(file){

      this.form.files.push(file);       
   
    },
    

    async submitForm(){

        if(this.passData  != null){
          console.log('update');
          this.updateSchool();
        }else{
          console.log('add scool');
          this.addSchool();
        }
    },

    async updateSchool(){



      this.isLoading = true;

      await axiosApi.put('api/schools/'+this.passData.id,  this.form).then(res=>{
        console.log(res);
        this.$emit("close", true);
        this.showToast();
      }).catch(err=>{
        
        console.log(err.response.status);

          if (err.response.status === 422) {
            this.error = err.response.data.errors;
          } else {
            this.$emit("hasError", err);
          }
 

      }).finally(()=>{
        this.isLoading = false;
      });



    },  


    showToast(){
      this.$swal({
        position: "top-end",
        icon: "success",
        showConfirmButton: false,
        title: 'Succesfully Saved',
        timer: 1700,
        toast:true,
        width: "300px",
        customClass: {
            title: 'text-red'
        },
        
      });
    },
    
    async addSchool() {
      this.isLoading = true;
      await axiosApi
        .post("api/schools", this.form)
        .then((res) => {
          console.log(res);
          this.$emit("close", true);
          this.showToast();
          
        })
        .catch((err) => {
          console.log(err.response.status);
          if (err.response.status === 422) {
            this.error = err.response.data.errors;
          } else {
            this.$emit("hasError", err);
          }
        })
        .finally(() => {
          this.isLoading = false;
        });
    },
  },
};
</script>

<style scoped>

.cs{
  max-height: 100vh;
  overflow-y: auto;
}
.action {
  width: 100%;
  display: flex;
  justify-content: end;
}
</style>
