v

<template>
  <main>
   
    <!-- <NoRecord v-if="schools.length<=0"/> -->
    <BaseCardShadow  shadow>
       <div class="d-flex justify-content-end ">
         <CustomButton mode="green" class="my-1 mb-2" @click="showForm">
           Add School
          </CustomButton>
    </div>
        <SchoolsTable  :isLoading="isShoolLoading" :schools="schools.data" >

          <template #default="data">

            <div class="flex flex-wrap justify-center align-content-center">
              <icon-button @click="selectSchool(data.school, 'Update School')" mode="blue" icon="fa-regular fa-pen-to-square"></icon-button>
              <icon-button mode="green"  icon="fa-regular fa-eye"></icon-button>
              <icon-button @click="selectSchool(data.school, 'Delete School')" mode="red" icon="fa-regular fa-trash-can"></icon-button>
            

          </div>
          </template>
        </SchoolsTable>
    </BaseCardShadow>
 

    <!--DIALOG FOR ADD AND UPDATE -->
    <teleport to="#app">
      <BaseFormDialog :title="openForm" :formtype="!!openForm" :formPersistent="false" :formWidth="'600'" >
        <SchoolForm @close="closeFormDialog" @hasError="showError" :passData='selectedSchool'/>
      </BaseFormDialog>
    </teleport>
 <!-- ERRO MODAL -->
    <teleport to="#app">
      <BaseErrorDialog
        v-if="!!requestError"
        :dialog="!!requestError"
        @close="clearError"
        :status="requestError.request.status.toString()"
        :message="requestError.request.statusText"
      >
      </BaseErrorDialog>
    </teleport>
  </main>
</template>

<script>
import BaseFormDialog from "../../components/dialogs/BaseFormDialog.vue";
import CustomButton from "../../components/CustomButton.vue";
import SchoolForm from "../forms/SchoolForm.vue";
import BaseErrorDialog from "../../components/dialogs/BaseErrorDialog.vue";
import SchoolsTable from "./school/SchoolsTable.vue";
import axiosApi from '../../api/axiosApi';
import NoRecord from '../../components/NoRecord.vue';
import BaseCardShadow from "../../components/BaseCardShadow.vue";
import IconButton from '../../components/IconButton.vue';
import TestForm from "../forms/TestForm.vue";

export default {
  components: {
    BaseCardShadow,
    CustomButton,
    BaseFormDialog,
    SchoolForm,
    BaseErrorDialog,
    SchoolsTable,
    NoRecord,
    IconButton ,
  },

  created () {
    
  },
  data() {
    return {
      openForm: null,
      requestError: null,
      selectedSchool: null,
      mode: 'Add School',
      schools: [],
      isShoolLoading: false,
    };
  },

  mounted () {
    this.loadSchoolData();
  },

  methods: {

    showForm(){
      
      this.selectedSchool = null;
      this.openForm = 'Add School';

    },
    


    selectSchool(school, action){
    
      if(school){      
        this.selectedSchool= school;
        if(action === 'Update School'){
          this.openForm = action;
        }

        if(action === "Delete School"){
          
          this.deleteShool(school);

        }


      
      }
      
    },
    
    async deleteShool(school){  


      this.$swal({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then( async (result)  =>  {
  if (result.isConfirmed) {

    await axiosApi.delete('api/schools/'+ school.id).then(res=>{

      this.loadSchoolData();
         this.$swal(
      'Deleted!',
      'Your data has been deleted.',
      'success'
    )
    }).catch(err=>{   

      console.log(err);
      
    });

  }
  
})



    
    },
    

   async loadSchoolData(){
        this.isShoolLoading = true;
        await axiosApi.get('api/schools').then(res=>{
          this.schools = res.data;

        }).catch(err=>{
          console.log(err);
        }).finally(()=>{
          this.isShoolLoading = false;
        });
    },

    showToast() {
      
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

    closeFormDialog(isDataSave) {

        
    
      if(isDataSave){
          this.loadSchoolData();
      }
      this.openForm = null;
    },

    showError(err) {
      this.requestError = err;
    },

    clearError() {
      this.requestError = null;
    },
  },
};
</script>

<style scoped>
main{

  transition: all 0.3s ease-in-out;
}
.sweet-icon {
  width: 40px;
  height: 40px;
}
</style>
