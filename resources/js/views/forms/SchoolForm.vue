<template>
  <w-card class="white--bg" content-class="pa0">
    <div class="inp mb-3">
      <div class="input-group">
        <input
          class="form-control shadow-none"
          type="text"
          placeholder="School Name"
          v-model="form.name"
        />
      </div>
      <span class="text-danger" v-if="!!error.name">{{ error.name[0] }}</span>
    </div>
    <div class="inp mb-3">
      <div class="input-group">
        <input
          class="form-control shadow-none"
          type="text"
          placeholder="Scholl Name"
          v-model="form.address"
        />
      </div>
      <span class="text-danger" v-if="!!error.address">{{ error.address[0] }}</span>
    </div>

    <div class="action mt-3">
      <CustomButton class="mr-2" @click="this.$emit('close')"> Close</CustomButton>
      <BaseSpinner v-if="isLoading" />
      <CustomButton v-else type="submit" @click="addSchool"> Save</CustomButton>
    </div>
  </w-card>
</template>

<script>
import CustomButton from "../../components/CustomButton.vue";
import BaseSpinner from "../../components/BaseSpinner.vue";
import axiosApi from "../../api/axiosApi";

export default {
  components: {
    CustomButton,
    BaseSpinner,
  },
  emits: ["close", "hasError"],
  data() {
    return {
      isLoading: false,
      error: {},
      requestError: null,
      form: {
        name: "",
        address: "",
      },
      validators: {
        required: (value) => !!value || "This field is required",
      },
    };
  },

  methods: {
    async addSchool() {
      this.isLoading = true;
      await axiosApi
        .post("api/schools", this.form)
        .then((res) => {
          this.$emit("close");
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
.action {
  width: 100%;
  display: flex;
  justify-content: end;
}
</style>
