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
                      <form @submit.prevent="registerUser" class="login-form">
  
                            <div class="inp mb-3">
                                <div >

                                    <input
                                    :class="['form-control shadow-none', { 'error-border': firstnameError }]"
                                    type="text" 
                                    placeholder="First name"
                                    v-model="form.first_name"
                                    >
                                </div>
                                <div class="error-card" v-if="!!error.first_name">
                                    {{ error.first_name[0] }}
                                  </div>
                                
                            </div>
                            
                            <div class="inp mb-3">
                                <div class="input-group ">
                                    <input 
                                    :class="['form-control shadow-none', { 'error-border': lastnameError }]"
                                    type="text" placeholder="Last name" 
                                    v-model="form.last_name"
                                    >
                                </div>
                                <div class="error-card" v-if="!!error.last_name">
                                    {{ error.last_name[0] }}
                                  </div>
                            </div>
                            <div class="inp mb-3">
                                <div class="input-group ">
                                    <input 
                                    :class="['form-control shadow-none', { 'error-border': emailError }]"
                                    
                                    type="email"
                                     placeholder="Email"
                                     v-model="form.email"
                                     >
                                </div>
                                <div class="error-card" v-if="!!error.email">
                                    {{ error.email[0] }}
                                  </div>
                            </div>
                          
                            <div class="inp mb-3">
                                <div class="input-group ">
                                    <input class="form-control shadow-none" v-if="showPassword" type="text" placeholder="Password" v-model="form.password">
                                    <input class="form-control shadow-none"  v-else type="password" placeholder="Password" v-model="form.password">
                                    <button  @click.prevent="showPassword=!showPassword" class="input-group-text">
                                        <span> <i :class="{'fa-regular fa-eye-slash': showPassword, 'fa-regular fa-eye': !showPassword }"></i> </span>
                                    </button>
                                </div>
                                <div class="error-card" v-if="!!error.password">
                                    {{ error.password[0] }}
                                  </div>
                            </div>
                            <div class="inp mb-3">
                                <div class="input-group ">
                                    <input class="form-control shadow-none" v-if="showConfirmPassword" type="text" placeholder="Confirm Password" v-model="form.password_confirmation">
                                    <input class="form-control shadow-none"  v-else type="password" placeholder="Confirm Password" v-model="form.password_confirmation">
                                    <button  @click.prevent="showConfirmPassword=!showConfirmPassword" class="input-group-text">
                                        <span> <i :class="{'fa-regular fa-eye-slash': showConfirmPassword, 'fa-regular fa-eye': !showConfirmPassword }"></i> </span>
                                    </button>
                                </div>
                            </div>
                
  
                <!-- <base-spinner></base-spinner> -->
                <base-spinner v-if="isRegisterLoading"></base-spinner>
                <div class=" mt-2" v-else>
                    <BaseButton> Register</BaseButton>
                  </div>
              </form>
              <div class=" text-center my-2 ">
                or
            </div>
              <base-spinner v-if="isGoogleLoading"></base-spinner>
                <GoogleButton v-else @click="continueWithSocialAccount" />

             
                                          <div class="text-center mt-3 font-weight-light">
                                            Already have an existing account? <router-link to="/login"> Login </router-link>
                                          </div>
                                      </div>
                                  </BaseCardShadow>
                             
  
          </div>
        </div>
      </div>
  
    </main>
  </template>
  
  <script>
  import axios from "axios";
  import BaseHeaderNoButton from '../../components/welcomepage/BaseHeaderNoButton.vue'
import BaseButton from "../../components/BaseButton.vue";
import GoogleButton from "../../components/GoogleButton.vue";
import BaseCardShadow from '../../components/BaseCardShadow.vue'

  
  export default {
    components: {
      BaseButton,
      BaseButton,
    GoogleButton,
    BaseHeaderNoButton,
    BaseCardShadow
    },
    computed: {
      firstnameError() {
        return !!this.error.first_name;
      },
      lastnameError() {
        return !!this.error.last_name;
      },
      emailError() {
        return !!this.error.email;
      },
      passwordError() {
        return !!this.error.password;
      },
      confirmpasswordError() {
        return !!this.error.password_confirmation;
      },
    },
  
    data() {
      return {
        form: {
          first_name: "",
          last_name: "",
          email: "",
          password: "",
          password_confirmation: "",
        },
  
        isRegisterLoading: false,
        isLoginLoading: false,
        isGoogleLoading: false,
        error: {},
        requestError: null,
        showPassword: false,
        showConfirmPassword: false,
      };
    },
  
    methods: {

        async continueWithSocialAccount() {
        this.isGoogleLoading = true;
      await this.$store
        .dispatch("logInWithSocialAccount")
        .then((res) => {
          window.location.href = res.data.url;
        })
        .catch((err) => {
          console.log(err);
        }).finally(()=>{
            this.isGoogleLoading = false;
        });
    },
      async loginUser(user){
        
        this.isLoginLoading  = true;
        await this.$store.dispatch('loginUser', user).then(res=>{
            localStorage.setItem('token', res.data);
            window.location.reload(true);
            
        }).catch(err=>{
          console.log(err.response);
            if(err.response.status === 422){  
              this.err  = err.response.data.errors;
            }else{
              this.requestError = err.response;
            }          
        }).finally(()=>{
          this.isLoginLoading  = false;
        });
        
      },
      async registerUser() {
            this.isRegisterLoading = true;
            await axios.post('api/register', this.form).then(()=>{
                  this.loginUser({
                    email: this.form.email,
                    password: this.form.password,
                    device_name: 'browser',
                  });
            }).catch((error)=>{
                if(error.response.status === 422){
                    this.error = error.response.data.errors;
 
                }else{
                  this.requestError = error;
                }
            }).finally(()=>{
                this.isRegisterLoading = false;
            });
      },
    },
  };
  </script>
  
  <style scoped>

  
  .form-control:focus {
    border-color: #bfc6be !important;
  }
label{
    color: rgb(175, 168, 168);
    font-size: 14px;
}


  main {
  
    min-height: 100vh;
  }
  section {
    padding: 0;
    margin: 0;
  }
  
  .error-border {
      border: 1px solid red;
    }
    .error-card {
      padding: 2px 4px;
      color: red;
      font-size: 14px;
      display: inline-block;
      border-radius: 4px;
    }
  </style>
  