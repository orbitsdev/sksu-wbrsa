<template>
  <w-card class="cs" content-class="pa0">
    <BaseInput
      label="School Name"
      :showLabel="false"
      v-model="form.name"
      :error="error.name"
    />
    <BaseInput
      label="Schol Address"
      :showLabel="false"
      v-model="form.address"
      :error="error.address"
    />

    <div v-if="data" >
      <w-div v-for='(item,index) in form.images' class="ma1" round :key='index'>
         {{ item.file }}
         <w-button class="ma1 ml-1 bg-danger" color="danger" @click='deleteSchoolImage(item.id)' > delete </w-button>
       </w-div>
    </div>

    <div class="inp mb-3">
      
      <DragAndDropFiles
      :passFiles="[]"
      label="Drop images here..."
      :passFiletype="'image'"
      :PdfPreview="false"
      :multiple="true"
      
      :isUpdating="data != null"
      @fileIsUploading="setFileIsLoading"
      @fileIsUploaded="setFiles"
      @fileIsDeleted="setFiles"
    
      />
    </div>

    <div class="action mt-3">
      <CustomButton class="mr-2" @click="handleCloseForm" >
        Close</CustomButton
      >
      <BaseSpinner v-if="isLoading" />
      <CustomButton
        v-else
        type="submit"
        @click="submitForm"
        :mode="'green'"
        
      >
         {{ data != null ? 'Update' : 'Save'}}</CustomButton
      >
    </div>
  </w-card>
</template>

<script>
import CustomButton from "../../components/CustomButton.vue";
import BaseSpinner from "../../components/BaseSpinner.vue";
import axiosApi from "../../api/axiosApi";
import DragAndDropFiles from "../../components/DragAndDropFiles.vue";
import BaseInput from "../../components/BaseInput.vue";
import axios from "axios";

export default {
  components: {
    CustomButton,
    BaseSpinner,
    DragAndDropFiles,
    BaseInput,
  },
  emits: ["close", "hasError"],

  props: {
    data: {
      type: [Object, Number],
      default: {},
    },
  },

  created() {

    if (this.data != null) {
        this.form = this.data;
    }
    console.log(this.data);
  },

  data() {
    return {
      isLoading: false,
      isFileLoading: false,
      error: {},
      requestError: null,
      selectedData: null,
      form: {
        name: "",
        address: "",
        images: [],
      },
      validators: {
        required: (value) => !!value || "This field is required",
      },
    };
  },

  methods: {


     submitForm() {  

      if(this.data != null){
        this.updateSchool();
        
      }else{
         this.addSchool();
      }

    },
    deleteSchoolImage(image_id) {
      axiosApi.get('/api/schools/delete-image?id=' + image_id)
        .then(({data})  => {
          if (data.success)
          {
            this.$swal({
              title: 'Success',
              icon: 'success',
              text : 'Image Deleted',
            })
           this.form.images = this.form.images.find((item) => item.id != image_id)
          } else {
            this.$swal({
              title: 'Warning',
              text: data.message,
              icon : 'warning',
            })
          }
        }).
        catch((err) => {
          console.log(error)
        })
    },

    // AXIOS METHOD 
    async addSchool() {
      this.isLoading = true;

      await axiosApi
        .post("api/schools", this.form)
        .then((res) => {
          this.$emit("close", true);
          this.showToast();
        })
        .catch((err) => {
          console.log(err);
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

    async updateSchool() {


      this.isLoading = true;

      await axiosApi
        .put("api/schools/" + this.data.id, this.form)
        .then((res) => {
          this.$emit("close", true);
          this.showToast({title: "Succesfully Update"});
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

    handleCloseForm() {

      
      if (this.form.images.length > 0) {
        this.$swal({
          title: "You have unsave upload files",
          text: "Are you sure do you want to close it?",
          icon: "info",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes",
        }).then((result) => {
          if (result.isConfirmed) {
      
            
            // IF DATA IS NOT NULL IT MEANS UPDATE
            if(this.data === null){
              this.deleteTemporyFiles();
            }
            this.$emit("close");
              
          }
        });
      } else {

        this.$emit("close");
      }
    },

    

    // LOCAL METHODS

    setFileIsLoading(value) {
      this.isFileLoading = value;
    },

    setFiles(file_collection) {
      this.form.images = file_collection;
    },

    addTheFile(files_collection) {
      this.form.images = files_collection;
    },

    removeTheFiles(filtered_files_collections) {
      if (filtered_files_collections.length != 0) {
        this.form.images = filtered_files_collections;
      } else {
        this.form.images = [];
      }
    },

    showToast({title}={title: "Succesfully Save"}) {
      this.$swal({
        position: "top-end",
        icon: "success",
        showConfirmButton: false,
        title:title,
        timer: 1700,
        toast: true,
        width: "300px",
        customClass: {
          title: "text-red",
        },
      });
    },

    async deleteTemporyFiles() {


      await axiosApi.post('api/image/upload/delete-tmp', {
        files: this.form.images
      }).then(res=>{
        console.log(res);
      }).catch(err=>{
        console.log(err);
      })


    },
    
  },
};
</script>

<style scoped>
.cs {
  max-height: 80vh;
  overflow-y: auto;
}
.action {
  width: 100%;
  display: flex;
  justify-content: end;
}
</style>
