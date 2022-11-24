<template>
    <main>
      <BaseHeaderNoButton/>
      
     <div style="height: 18px"></div>
     <div class="content-wrapper d-flex align-items-center auth">
         <div class="row flex-grow">
             <div class="col-lg-4 mx-auto">
                 <BaseCardShadow>
                  <div class="auth-form-light text-left p-5">
                       <div class="brand-logo">
                          <img src="../../../../public/loginpage/assets/images/logo.svg">
                      </div> 
                   
                      <form @submit.prevent="sendEmailForRequestPassword"  class="login-form">
                        <BaseInput label="Email" type="email" :showLabel="false" v-model="form.email" :error="error.email"/>
                           
                           
                           
                
  
                <!-- <base-spinner></base-spinner> -->
                <base-spinner v-if="isLoading"></base-spinner>
                <div class=" mt-2" v-else>
                    <BaseButton> Send Request </BaseButton>
                  </div>
              </form>
             
            
  
             
                                          <div class="text-center mt-3 font-weight-light">
                                             <router-link to="/login"> Back to login page </router-link>
                                          </div>
                                      </div>
                                   
                                      
                                   
                                    </BaseCardShadow>
                             
  
          </div>
        </div>
      </div>
  

      
<teleport to="#app">


  <BaseErrorDialog v-if="!!requestError" :dialog="!!requestError" @close="clearError" :status="requestError.request.status.toString()" :message="JSON.parse(requestError.request.response)[0]" :buttontext="'OK'"> </BaseErrorDialog>

     
  </teleport>
    </main>
  </template>
  
  <script>
  
  
  import axios from "axios";
  
  import BaseHeaderNoButton from '../../components/welcomepage/BaseHeaderNoButton.vue'
  import BaseButton from "../../components/BaseButton.vue";
  import BaseCardShadow from '../../components/BaseCardShadow.vue';
  import BaseErrorDialog from '../../components/dialogs/BaseErrorDialog.vue';
  import BaseInput from "../../components/BaseInput.vue";
  
  export default {
    components: {
      BaseButton,
      BaseHeaderNoButton,
      BaseCardShadow,
      BaseErrorDialog,
      BaseInput,
    },


    data() {
      return {
        form:{
          email: '',
       
        },
        error: {},
        requestError: '',
        isLoading: false,
      }
    },

    methods: {

      clearError(){
        this.requestError = null;
        this.error ={};
      },
    async  sendEmailForRequestPassword(){
        

      this.isLoading = true;
        await axios.post('api/request-password-reset', this.form).then(res=>{
          console.log(res);
          this.$router.replace(`/request-succesfully-sent/${res.data}`);
        }).catch(err=>{
          if (err.response.status === 422) {
            this.error = err.response.data.errors;
          } else {

            console.log(err);
           this.requestError = err;
            
          }
        }).finally(()=>{
          this.isLoading = false;
        });
        
      }
    }
  
   
  };
  </script>
  
  <style scoped>
  
  .mb-3 button{
    outline: none;
  }
  main {
  
    min-height: 100vh;
  }
  section {
    padding: 0;
    margin: 0;
  }
  
  </style>
  