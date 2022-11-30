



<template>
  <div class="dialog-wrapper">
    <w-dialog
      v-model="formtype"
      @close="this.$emit('close')"
      :width="formWidth"
      :transition="formTransition"
      persistent
      :title="title"

      title-class="form-dialog-header"
    >
      <slot > DYNAMIC COTENT </slot>


    </w-dialog>
  </div>

</template>

<script>

import CustomButton from '../CustomButton.vue';
export default {
   
    components: {
        CustomButton,
    },
  
  emits: ["close"],

  props: {
    formtype: {
      type: Boolean,
      default: false,
      required: false,
    },
    title: {
      type: String,
      required: false,
      default: null,
    },
    formWidth: {
      type: String,
      required: false,
      default: '680',
    },
    formTransition: {
      type: String,
      required: false,
      default: 'scale',
    },

    formPersistent: {
      type: Boolean,
      default: true,
      required: false,
    },
    


   
  },
};
</script>

<style scoped>
.dialog-wrapper {
  z-index: 1000 !important;
}
</style>
