<template>
  <section>
    <BaseScreenLoading v-if="isScreenLoading" />
    <div v-else>
      Dashboard
      <hr />
      {{ user }}
      {{ token }}

        <h1 v-if="hasRole('admin')">Show  Admin </h1>
        <h1 v-if="hasRole('user')">Show User </h1>
        <h1 v-if="hasRole('developer')">Show Developer </h1>
      <hr />
{{ roles }}
      <BaseSpinner v-if="isLogoutLoading" />
      <base-button @click="logoutUser" v-else> Logout</base-button>
      
    </div>
  </section>
</template>

<script>
// import axios from "axios";
// const token = localStorage.getItem('token');
// axios.defaults.headers.common['Authorization']= "Bearer "+ token;

import axiosApi from "../../api/axiosApi";
import BaseButton from "../../components/BaseButton.vue";
import BaseScreenLoading from "../../components/BaseScreenLoading.vue";
import BaseSpinner from "../../components/BaseSpinner.vue";

import { mapActions } from "vuex";
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      roles: ['developer','admin'],
      isScreenLoading: false,
      isLogoutLoading: false,
      currentUser: {},
      currentToken: {},
    };
  },
  created () {
      this.getUserDetails();
  },
  computed: {
    hasRole(){
      return (role)=> this.roles.includes(role);
    },

    isAdmin(){
      return this.roles.includes('admin','user','developer');
    },
    isUser(){
      return this.roles.includes('user');
    },
    isDeveloper(){
      return this.roles.includes('developer');
    },
    ...mapGetters(["user", "token"]),
  },
  components: { BaseButton, BaseScreenLoading, BaseSpinner },
  methods: {

    async getUserDetails(){
      await axiosApi.get('api/user').then(res=>{
        console.log(res.data);
      }).catch(e=>{
        console.log(e);
      });
    },
    ...mapActions(["setUser"]),
    async getAllUsers() {
      await axiosApi
        .get("api/admin/users")
        .then((response) => {
          console.log(response);
        })
        .catch((error) => {
          console.log(error);
        });
    },

    async logoutUser() {
      try {
        this.isLogoutLoading = true;
        await axiosApi
          .post("api/logout")
          .then((response) => {
                console.log(response);
                localStorage.removeItem('token');
                if(this.user!= null){
                  this.$store.dispatch('logoutUser');
                }
                this.$router.replace("/login");

          })
          .finally(() => {
            this.isLogoutLoading = false;
          });
      } catch (e) {
        coonsole.log(e);
      }
    },

    
  },

  
};
</script>

<style scoped>
div{
  padding:20px
}
</style>
