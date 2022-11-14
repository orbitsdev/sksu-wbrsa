<template>
  <section>
    <BaseScreenLoading v-if="isScreenLoading" />
    <div v-else>
      Dashboard
      <hr />
      <span v-if="user"> {{ user }}</span>
      <span v-if="user"> {{ user.token }}</span>
      <span v-if="user"> {{ user.roles }}</span>

      
      <hr />

      <p> Show Admin </p>
      <p> Show Osas </p>
      <p> Show User </p>
      <hr />

        <BaseSpinner v-if="isLogoutLoading" />
      <base-button @click="logoutUser" v-else> Logout</base-button>
      
    </div>
  </section>
</template>

<script>
// import axios from "axios";
// const token = localStorage.getItem('token');
// axios.defaults.headers.common['Authorization']= "Bearer "+ token;


import can from '../../gates/can';
import axiosApi from "../../api/axiosApi";
import BaseButton from "../../components/BaseButton.vue";
import BaseScreenLoading from "../../components/BaseScreenLoading.vue";
import BaseSpinner from "../../components/BaseSpinner.vue";


import { mapGetters } from "vuex";
export default {
  data() {
    return {
    
      isScreenLoading: false,
      isLogoutLoading: false,
    
    };
  },

  mounted () {

  },


  created () {
      this.getUserDetails();
  },
  computed: {
    
    ...mapGetters(['user']),
    
 
},
  components: { BaseButton, BaseScreenLoading, BaseSpinner },
  methods: {

    async getUserDetails(){

      await this.$store.dispatch('getUserDetails').then(res=>{
          const token = localStorage.getItem('token');
          this.$store.commit('setUserDetails', {
            user: res.data.user,
            roles: res.data.roles,
            token: token 
          });


          console.log(can('developer'));

      }).catch(err=>{

        console.log(err);
      }).finally(()=>{
        });
    },

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
