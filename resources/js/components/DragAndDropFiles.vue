<template>
  {{ this.isUpdating }}
  {{ this.files }}
  <file-pond
    name="files"
    ref="pond"
    allowPdfPreview="false"
    allowFileSizeValidation="true"
    :class="filePondStyle"
    :label-idle="label"
    :accepted-file-types="fileType"
    :allow-multiple="multiple"
    :maxFileSize="maxSize"
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
          Authorization: 'Bearer ' + this.authtoken,
        },
        onload: this.handleFilePondLoad,
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

    isUpdating: {
      type: Boolean,
      required: false,
      default: true,
    },
  },

  emits: ["fileIsUploaded", "fileIsDeleted", "fileIsUploading", "enitialFileIsRemove"],

  created() {
    this.setFileType();
    this.setInitialFiles();
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
      initAdd: {},
      files: [],
      succes_files: [],
      initial_files: [],
      failed_files: 0,
      fileType:
        "image/*, application/msword, application/pdf,  text/plain , application/json, application/vnd.openxmlformats-officedocument.wordprocessingml.document",
    };
  },

  methods: {
    // FILEPOND METHODS
    handleFilePondInit() {
      // if(this.isUpdating){
      //   this.files = [];
      //   this.passFiles.forEach(initilaFiles => {
      //     this.files.push({
      //       source: `/uploads/files/${initilaFiles.folder}/${initilaFiles.file}`,
      //       options: {
      //         type: 'local',
      //         metadata:{
      //           poster: '/'
      //         }
      //       }
      //     });
      //   });
      // }
    },

    // FILE IS FINISHED LOAD
    handleFilePondLoad(response) {
      
      if (response != "") {
        const res = JSON.parse(response);

        if (this.isUpdating) {
        } else {
          this.files.push(res);
          this.succes_files.push(res.file);
          const newFileCollection = this.filterFile(response);
          // //  pass unique folder name and the actual file name
          this.$emit("fileIsUploaded", newFileCollection);
        }

        return res.folder;
      } else {
        this.failed_files++;
      }
    },

    // REVERT METHOD
    handleFilePondRevert(uniquid, load, error) {

      if (this.isUpdating) {

      } else {
        axiosApi
          .delete("api/image/upload/revert", {
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
      }

      load();
    },

    // DELETE TEMP
    async deleteTempFiles(uniquid) {
      axiosApi
        .delete("api/image/upload/revert", {
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
    },
    // FILTER ARRAY
    clearUploadedFiles(uniquid) {
      axiosApi
        .post("api/image/upload/get-folder", {
          folder: uniquid,
        })
        .then((res) => {
          console.log(res);
        })
        .catch((err) => {
          console.log(err);
        });
    },

    // FILE START LOADED
    handleFilePondInitFile(file) {
      this.$emit("fileIsUploading", true);
    },

    // ALL FILES IS LOADED
    handleFilePondProcessFiles() {
      this.$emit("fileIsUploading", false);
    },

    // RETURN NEW VALUE OF FILES
    filterFile(response) {
      return this.files.map((fileDetails) => fileDetails);
    },

    // TRIGGER ONLY IF YOU PASS DATA
    setInitialFiles() {
      if (this.isUpdating) {
        this.passFiles.forEach((initilaFiles) => {
          this.files.push(`/uploads/files/${initilaFiles.folder}/${initilaFiles.file}`);
        });
      }
    },

    getInitialFileData() {
      axiosApi
        .post("api/image/upload/get-folder", {
          files: this.passFiles,
        })
        .then((res) => {})
        .catch((err) => {
          console.log(err);
        });
    },

    // SET DEFAULT TYPE
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
  },
};
</script>

<style scoped></style>
