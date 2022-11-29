
<template>
  
{{ files }}

  <file-pond
    name="files"
    :class="filePondStyle"
    ref="pond"
    allowFileSizeValidation="true"
    :label-idle="label"
    :accepted-file-types="fileType"
    :allow-multiple="multiple"
    :maxFileSize="maxSize"
    allowPdfPreview="false"
    :itemInsertLocation="insertFile"
    :pdfPreviewHeight="pdfHeight"
    credits="false"
    pdfComponentExtraParams="toolbar=0&view=fit&page=1"
    :server="{
      url: '',
      timeout: 7000,
      process: {
        url: '/api/image/upload/local',
        timeout: 7000,
        methods: 'POST',
        withCredentials: true,
        headers: {
          Authorization: 'Bearer ' + authtoken,
        },
        onload: handleFilePondLoad,
        onerror: () => {},
      },
      revert: handleFilePondRevert,
    }"
    v-bind:files="files"
    @init="handleFilePondInit"
    @initfile="handleFilePondInitFile"
    @processfiles="handleFilePondProcessFiles"
  >
  </file-pond>
</template>
<script>
import axiosApi from "../api/axiosApi";
import vueFilePond from "vue-filepond";

// Components
import BaseFileCard from "./BaseFileCard.vue";

// Import plugins
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js";
import FilePondPluginImagePreview from "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js";
import FilePondPluginFilePoster from "filepond-plugin-file-poster";
import FilePondPluginImageCrop from "filepond-plugin-image-crop";
import FilePondPluginFileImageValidateSize from "filepond-plugin-image-validate-size";
import FilePondPluginFileValidateSize from "filepond-plugin-file-validate-size";
import FilePondPluginGetFile from "filepond-plugin-get-file";
import FilePondPluginPdfPreview from "filepond-plugin-pdf-preview";

import FilePondPluginImageOverlay from "filepond-plugin-image-overlay";

// Import styles
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import "filepond-plugin-get-file/dist/filepond-plugin-get-file.min.css";
import "filepond-plugin-pdf-preview/dist/filepond-plugin-pdf-preview.min.css";
import "filepond-plugin-image-overlay/dist/filepond-plugin-image-overlay.css";

// Create FilePond component
const FilePond = vueFilePond(
  FilePondPluginImageCrop,
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview,
  FilePondPluginFileImageValidateSize,
  FilePondPluginFileValidateSize,
  FilePondPluginFilePoster,
  // FilePondPluginPdfPreview ,
  FilePondPluginImageOverlay

  // FilePondPluginGetFile
);

export default {
  props: {
    label: {
      type: String,
      required: false,
      default: "Drop files here...",
    },
    passFiletype: {
      type: String,
      required: false,
      default: "all",
    },

    multiple: {
      type: Boolean,
      default: true,
    },
    maxSize: {
      type: String,
      required: false,
      default: "40MB",
    },
    insertFile: {
      type: String,
      required: false,
      default: "before",
    },
    pdfHeight: {
      type: String,
      required: false,
      default: "120",
    },
    PdfPreview: {
      type: Boolean,
      required: false,
      default: true,
    },
    filePondStyle: {
      type: String,
      required: false,
      default: "filepond ",
    },


    passFiles: {
      type: [Array, Number],
      required: false,
      default: null,
    },

  },

  emits: ["fileIsUploaded", "fileIsDeleted", "fileIsUploading"],

  created() {
    this.setFileType();
    // this.setInitialFiles();
    this.authtoken = localStorage.getItem("token");
  },
  mounted() {

  },
  components: {
    FilePond,
    BaseFileCard,
  },
  data() {
    return {
      authtoken: null,
      files: [],
      succes_files: [],
      failed_files: 0,

      file_to_delete: [],
      fileType:
        "image/*, application/msword, application/pdf,  text/plain , application/json, application/vnd.openxmlformats-officedocument.wordprocessingml.document",
    };
  },

  methods: {
    setInitialFiles() {
      if (this.passFiles.length > 0) {
        this.files = this.passFiles;
      }
    },
    setFileType() {
      if (this.passFiletype == "image") {
        this.fileType = "image/*";
      }

      if (this.passFiletype == "pdf") {
        this.fileType = "application/pdf";
      }

      if (this.passFiletype == "pdf|docx" || this.passFiletype == "pdf|docs") {
        this.fileType =
          "application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document";
      }

      if (this.passFiletype == "json") {
        this.fileType = "application/json";
      }
      if (this.passFiletype == "text") {
        this.fileType = "text/plain";
      }
    },
    handleFilePondInitFile(file) {
      this.$emit("fileIsUploading", true);
      console.log("files loaded ");
    },
    handleFilePondProcessFiles() {
      this.$emit("fileIsUploading", false);
      console.log("all files finish");
    },

    handleFilePondInit() {
    },

    handleFilePondLoad(response) {
      if (response != "") {
        const res = JSON.parse(response);
        this.files.push(res);
        this.succes_files.push(res.file);
        const newFileCollection = this.files.map((fileDetails) => fileDetails);
        //  pass unique folder name and the actual file name
        this.$emit("fileIsUploaded", newFileCollection);
        return res.folder;
      } else {
        this.failed_files++;
      }
    },

    handleFilePondRevert(uniquid, load, error) {
      axiosApi.delete("api/image/upload/revert", {
          data: {
            folder: uniquid,
          },
        })
        .then((response) => {
          this.succes_files = this.succes_files.filter(
            (file) => file != response.data.file
          );
          const indexOfObject = this.files.findIndex((object) => {
            return object.folder === response.data.folder;
          });
          this.files.splice(indexOfObject, 1);
          const newFilteredFiles = this.files.map((fileDetails) => fileDetails);
          this.$emit("fileIsDeleted", newFilteredFiles);
        });
      load();
    },

   

  },
};
</script>

<style scoped></style>
