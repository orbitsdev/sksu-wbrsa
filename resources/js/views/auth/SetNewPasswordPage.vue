<template>



  <BaseScreenLoading v-if="screenLoading" />
  <main v-else>
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
                
                    <form @submit.prevent="setNewPassword" class="login-form">

                      <BaseInput label="Email" type="email" v-model="form.email" :error="error.email"/>
                      <BasePasswordInput @showPassword="showPassword=!showPassword" :show="showPassword" label="Password"  v-model="form.password" :error="error.password"/>
                      <BasePasswordInput @showPassword="showConfirmPassword=!showConfirmPassword" :show="showConfirmPassword" label="ConfirmPassword"  v-model="form.password_confirmation" />

                         
                       
                         
              

              <!-- <base-spinner></base-spinner> -->
              <base-spinner v-if="isLoading"></base-spinner>
              <div class=" mt-2" v-else>
                  <BaseButton> Change Password </BaseButton>
                </div>
            </form>
           
          

           
                                        <div class="text-center mt-3 font-weight-light">
                                           <router-link to="/login"> Go to login </router-link>
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
import BaseScreenLoading from '../../components/BaseScreenLoading.vue';
import BaseHeaderNoButton from '../../components/welcomepage/BaseHeaderNoButton.vue'
import BaseButton from "../../components/BaseButton.vue";
import BaseCardShadow from '../../components/BaseCardShadow.vue';
import BaseErrorDialog from '../../components/dialogs/BaseErrorDialog.vue';
import BaseInput from '../../components/BaseInput.vue';
import BasePasswordInput from '../../components/BasePasswordInput.vue';
export default {

  components: {
    BaseButton,
    BaseHeaderNoButton,
    BaseCardShadow,
    BaseErrorDialog,
    BaseInput,
    BasePasswordInput,
    
  },

  mounted () {
    this.setCredential();
  },
  data() {
    return {
      form:{
        email: '',
        token: '',
        password:'',
        password_confirmation:'',
        actual_email: '',
      },
     
      error: {},
      requestError: '',
      isLoading: false,
      screenLoading: false,
      showPassword: false,
      showConfirmPassword: false,
    }
  },

  methods: {

    clearError(){
      this.requestError = null;
      this.error ={};
    },

    async setNewPassword (){
        this.isLoading = true;

        await axios.post('api/set-password', this.form).then(res=>{
          console.log(res);
          this.$router.replace('/login');
        }).catch(err=>{
          console.log(err);
          if(err.response.status === 422){  
              this.error  = err.response.data.errors;
            }else{
              console.log(err);
            this.requestError = err;
            } 
        }).finally(()=>{
          this.isLoading = false;
        });

    },

    async setCredential(){


      if(this.$route.query.email && this.$route.query.token){

        this.form.email = this.$route.query.email;
        this.form.actual_email = this.$route.query.email;
        this.form.token = this.$route.query.token;
        
       
         
        
      }
      
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
