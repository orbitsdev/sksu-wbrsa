v

<template>
  <div>
    <w-card shadow>
      <div class="d-flex justify-content-end">
        <!-- <CustomButton class="my-1 mb-3" @click="showToast"> TOast </CustomButton> -->
        <CustomButton class="my-1 mb-3" @click="openForm = 'school-form'">
          Add School
        </CustomButton>
      </div>
    </w-card>

    <teleport to="#app">
      <BaseFormDialog title="Add School" :formtype="!!openForm">
        <SchoolForm @close="closeFormDialog" @hasError="showError" />
      </BaseFormDialog>
    </teleport>

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
  </div>
</template>

<script>
import BaseFormDialog from "../../components/dialogs/BaseFormDialog.vue";
import CustomButton from "../../components/CustomButton.vue";
import SchoolForm from "../forms/SchoolForm.vue";
import BaseErrorDialog from "../../components/dialogs/BaseErrorDialog.vue";

export default {
  components: {
    CustomButton,
    BaseFormDialog,
    SchoolForm,
    BaseErrorDialog,
  },

  data() {
    return {
      openForm: null,
      requestError: null,
    };
  },

  methods: {
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

    closeFormDialog() {
      this.openForm = null;
      console.log("close");
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
.sweet-icon {
  width: 40px;
  height: 40px;
}
</style>
