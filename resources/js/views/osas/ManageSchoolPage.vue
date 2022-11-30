v

<template>
  <main>
    <BaseCardShadow shadow>
      <div class="d-flex align-items-center justify-content-end">
        <BaseSpinner v-if="isMultipleButtonLoading" />
        <CustomButton
          v-if="selectedMultipleSchool.length > 0"
          mode="red"
          @click="showConfirmationForMultipleDelete"
        >
          Delete Selected School
        </CustomButton>
        <input
          type="text"
          v-model="query"
          class="p-1 rounded mx-1 focus:outline-none"
          placeholder="Search.."
        />
        <BaseSpinner v-if="isDeleteSchoolLoading" />
        <CustomButton
          v-else
          mode="red"
          class="mr-1"
          @click="showDeleteAllRecordConfirmation"
        >
          <i class="fa-regular fa-trash-can"></i> Delete All
        </CustomButton>
        <CustomButton mode="green" @click="showForm"> Add School </CustomButton>
      </div>
      <img :src="myImage[0]"  width="100"  height="100"/>
      <img :src="myImage[1]"  width="100"  height="100"/>
      <SchoolsTable
        class="mt-2"
        :headers="headers"
        :isLoading="isShoolLoading"
        :schools="schools.data"
      >
        <template #first="data">
          <input
            type="checkbox"
            v-model="selectedMultipleSchool"
            :value="data.school.id"
          />

        </template>
        <template #default="data">
          <div class="flex flex-wrap justify-center align-content-center">
            <icon-button
              @click="selectSchool(data.school.id, 'Update School')"
              mode="blue"
              icon="fa-regular fa-pen-to-square"
            ></icon-button>
            <icon-button mode="green" icon="fa-regular fa-eye"></icon-button>
            <icon-button
              @click="selectSchool(data.school.id, 'Delete School')"
              mode="red"
              icon="fa-regular fa-trash-can"
            ></icon-button>
          </div>
        </template>
      </SchoolsTable>
    </BaseCardShadow>

    <!--DIALOG FOR ADD AND UPDATE -->
    <teleport to="#app">
      <BaseFormDialog
        :title="openForm"
        :formtype="!!openForm"
        :formPersistent="false"
        :formWidth="'600'"
      >
        <SchoolForm
          @close="closeFormDialog"
          @hasError="showError"
          :data="selectedSchool"
        />
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
import { toRefs, toRef } from "vue";



import BaseFormDialog from "../../components/dialogs/BaseFormDialog.vue";
import CustomButton from "../../components/CustomButton.vue";
import SchoolForm from "../forms/SchoolForm.vue";
import BaseErrorDialog from "../../components/dialogs/BaseErrorDialog.vue";
import SchoolsTable from "./school/SchoolsTable.vue";
import axiosApi from "../../api/axiosApi";
import NoRecord from "../../components/NoRecord.vue";
import BaseCardShadow from "../../components/BaseCardShadow.vue";
import IconButton from "../../components/IconButton.vue";
import BaseSpinner from "../../components/BaseSpinner.vue";
import BaseInput from "../../components/BaseInput.vue";
import BaseSearchInput from "../../components/BaseSearchInput.vue";

export default {
  components: {
    BaseSpinner,
    BaseCardShadow,
    CustomButton,
    BaseFormDialog,
    SchoolForm,
    BaseErrorDialog,
    SchoolsTable,
    NoRecord,
    IconButton,
    BaseInput,
    BaseSearchInput,
  },

  created() {


  },

  data() {
    return {
      myImage: [
        "/assets/google.png",
        "/storage/app/google.png",
      ],
      headers: ["School", "Address", "Images", "", ""],
      openForm: null,
      requestError: null,
      selectedSchool: null,
      selectedMultipleSchool: [],
      mode: "Add School",
      schools: [],
      query: "",
      isDeleteSchoolLoading: false,
      isShoolLoading: false,
      isMultipleButtonLoading: false,
    };
  },

  mounted() {
    this.loadSchoolData();
  },

  watch: {
    query(newValue, oldValue) {
      this.searchSchool();
    },
  },
  methods: {
    // CRUD METHODS

    // SHOW FROM
    showForm() {
      this.selectedSchool = null;
      this.openForm = "Add School";
    },

    // LOAD SCHOOL DATA
    async loadSchoolData() {
      this.isShoolLoading = true;
      await axiosApi
        .get("api/schools")
        .then((res) => {
          this.schools = Object.freeze(res.data);
        })
        .catch((err) => {
          console.log(err);
        })
        .finally(() => {
          this.isShoolLoading = false;
        });
    },


    // DELETE SELECTED SCHOOL
    async deleteSelectedSchool(school) {
      await axiosApi
        .delete("api/schools/" + school.id)
        .then((res) => {
          console.log(res.data);
          this.loadSchoolData();
          this.$swal("Deleted!", "Your data has been deleted.", "success");
        })
        .catch((err) => {
          this.requestError = err;
        });
    },
   

    // DELETE MULTILPLE SCHOOL
    showConfirmationForMultipleDelete(){
      this.showCustomConfirmationDialog({
        text: `Do you want to delete these records , You won't be able to revert this!`,
        confirmButtonText: "Yes Delete these school records",
        passFunction: this.deleteMultipleSelected,
      });
    },
    async deleteMultipleSelected() {
      this.isMultipleButtonLoading = true;
      await axiosApi
        .post("/api/schools/delete/multiple-selected", {
          schools: this.selectedMultipleSchool,
        })
        .then((res) => {
          console.log(res);
            this.selectedMultipleSchool= [];
          this.loadSchoolData();
        })
        .finally(() => {
          this.isMultipleButtonLoading = false;
        });
    },

     // DELETE ALL SHOOL RECORD
     async deleteAllRecord() {
      this.isDeleteSchoolLoading = true;
      await axiosApi
        .post("api/schools/delete/all")
        .then((res) => {
          console.log(res);
          this.loadSchoolData();
          this.$swal("Deleted!", "Your data has been deleted.", "success");
        })
        .catch((err) => {
          this.requestError = err;
        })
        .finally(() => {
          this.isDeleteSchoolLoading = false;
        });
    },


    // SEARCH SCHOOL
    async searchSchool() {
      this.isShoolLoading = true;
      await axiosApi
        .post("/api/schools/search", {
          query: this.query,
        })
        .then((res) => {
          this.schools = res.data;
        })
        .finally(() => {
          this.isShoolLoading = false;
        });
    },

    // SELECT SPECIFIC SCHOOL
    selectSchool(schoolId, action) {
      this.selectedSchool = this.schools.data.find(
        (schoolDetails) => schoolDetails.id == schoolId
      );

      if (action === "Update School") {
        this.openForm = action;
      }

      if (action === "Delete School") {
        this.showCustomConfirmationDialog({
          passFunction: () => {
            this.deleteSelectedSchool(this.selectedSchool);
          },
        });
      }
    },

    
    // SHOW CONFIRMATION BEFORE DELEING ALL RECORD 
    showDeleteAllRecordConfirmation() {
      this.showCustomConfirmationDialog({
        text: " Do you want to delete all record , You won't be able to revert this!",
        confirmButtonText: "Yes Delete all school record",
        passFunction: this.deleteAllRecord,
      });
    },

    
 // CUSTOM CONFIRMATION DIALOG 
    showCustomConfirmationDialog({
      title = "Are you sure?",
      text = "You won't be able to revert this!",
      icon = "warning",
      confirmButtonText = "Yes, delete it!",
      passFunction,
      passCancelFunction,
    }) {
      this.$swal({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: confirmButtonText,
      }).then(async (result) => {
        if (result.isConfirmed) {
          passFunction();
        }
      });
    },

    showToast({title="Succesfully Saved",}) {
      this.$swal({
        position: "top-end",
        icon: "success",
        showConfirmButton: false,
        title: title,
        timer: 1700,
        toast: true,
        width: "300px",
        customClass: {
          title: "text-red",
        },
      });
    },

    closeFormDialog(isDataSave = null) {
      if (isDataSave) {
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
main {
  transition: all 0.3s ease-in-out;
}
.sweet-icon {
  width: 40px;
  height: 40px;
}
</style>
