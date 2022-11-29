v

<template>
  <main>
    <BaseCardShadow shadow>
      <div class="d-flex justify-content-end">
        <div>
          <BaseSpinner v-if="isDeleteSchoolLoading" />
          <CustomButton
            v-else
            mode="red"
            class="mr-1"
            @click="showDeleteAllRecordConfirmation"
          >
            <i class="fa-regular fa-trash-can"></i> Delete All
          </CustomButton>
        </div>
        <CustomButton mode="green" @click="showForm"> Add School </CustomButton>
      </div>
      <SchoolsTable class="mt-2" :isLoading="isShoolLoading" :schools="schools.data">
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
  },

  created() {},
  data() {
    return {
      openForm: null,
      requestError: null,
      selectedSchool: null,
      mode: "Add School",
      schools: [],
      isDeleteSchoolLoading: false,
      isShoolLoading: false,
    };
  },

  mounted() {
    this.loadSchoolData();
  },

  methods: {
    showForm() {
      this.selectedSchool = null;
      this.openForm = "Add School";
    },

    selectSchool(schoolId, action) {
   
        this.selectedSchool = this.schools.data.find((schoolDetails) => schoolDetails.id == schoolId);
          console.log(this.selectedSchool);
          
        if (action === "Update School") {
          this.openForm = action;
        }

        if (action === "Delete School") {
          this.showCustomConfirmationDialog({
            passFunction: () => {
              this.deleteSelectedSchool(selectedSchool);
            },
          });
        }

      

    },

    async loadSchoolData() {
      this.isShoolLoading = true;
      await axiosApi
        .get("api/schools")
        .then((res) => {
          this.schools = res.data;
        })
        .catch((err) => {
          console.log(err);
        })
        .finally(() => {
          this.isShoolLoading = false;
        });
    },

    async deleteSelectedSchool(school) {
      await axiosApi
        .delete("api/schools/" + school.id)
        .then((_) => {
          this.loadSchoolData();
          this.$swal("Deleted!", "Your data has been deleted.", "success");
        })
        .catch((err) => {
          this.requestError = err;
        });
    },

    showDeleteAllRecordConfirmation() {
      this.showCustomConfirmationDialog({
        text: " Do you want to delete all record , You won't be able to revert this!",
        confirmButtonText: "Yes Delete all school record",
        passFunction: this.deleteAllRecord,
      });
    },
    async deleteAllRecord() {
      this.isDeleteSchoolLoading = true;
      await axiosApi
        .post("api/schools/delete/all")
        .then((res) => {
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

    showCustomConfirmationDialog({
      title = "Are you sure?",
      text = "You won't be able to revert this!",
      icon = "warning",
      confirmButtonText = "Yes, delete it!",
      passFunction,
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

    showToast() {
      this.$swal({
        position: "top-end",
        icon: "success",
        showConfirmButton: false,
        title: "Succesfully Saved",
        timer: 1700,
        toast: true,
        width: "300px",
        customClass: {
          title: "text-red",
        },
      });
    },

    closeFormDialog(isDataSave) {
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
