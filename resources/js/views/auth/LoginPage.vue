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
                    <form @submit.prevent="loginUser" class="login-form">

                         
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
                              <button id="2" tabindex="-2" @click.prevent="showPassword=!showPassword" class="input-group-text" >
                                <span> <i :class="{'fa-regular fa-eye-slash': showPassword, 'fa-regular fa-eye': !showPassword }"></i> </span>
                              </button>
                            </div>
                            <div class="error-card" v-if="!!error.password">
                              {{ error.password[0] }}
                            </div>
                            <div class="mt-2"></div>
                            <router-link to="/forgotpassword" > Forgot password?</router-link>
                          </div>
              

              <!-- <base-spinner></base-spinner> -->
              <base-spinner v-if="isLoading"></base-spinner>
              <div class=" mt-2" v-else>
                  <BaseButton> Login</BaseButton>
                </div>
            </form>
           
            <div class=" text-center my-2 ">
              or
          </div>
            <base-spinner v-if="isGoogleLoading"></base-spinner>
              <GoogleButton v-else @click="continueWithSocialAccount" />

           
                                        <div class="text-center mt-3 font-weight-light">
                                          Dont have an account? <router-link to="/register"> Signup </router-link>
                                        </div>
                                    </div>
                                 
                                    
                                 
                                  </BaseCardShadow>
                           

        </div>
      </div>
    </div>

    

<teleport to="#app">

<BaseErrorDialog v-if="!!requestError" :dialog="!!requestError" @close="clearError" :status="requestError.request.status.toString()" :message="requestError.request.statusText"> </BaseErrorDialog>
  
</teleport>
    
  </main>
</template>

<script>


import axios from "axios";
import BaseSpinner from '../../components/BaseSpinner.vue';
import BaseHeaderNoButton from '../../components/welcomepage/BaseHeaderNoButton.vue'
import BaseButton from "../../components/BaseButton.vue";
import GoogleButton from "../../components/GoogleButton.vue";
import BaseCardShadow from '../../components/BaseCardShadow.vue';
import BaseErrorDialog from '../../components/dialogs/BaseErrorDialog.vue';

export default {
  components: {
    BaseButton,
    GoogleButton,
    BaseHeaderNoButton,
    BaseCardShadow,
    BaseErrorDialog,
    BaseSpinner,
  },

  computed: {


      emailError() {
        return !!this.error.email;
      },
      passwordError() {
        return !!this.error.password;P
      },
    },

    mounted () {
     
      this.showAuthError();
    
    },

  data() {
    return {
      form: {
        email: "admin@gmail.com",
        password: "@admin123",
        device_name: "browser",
      },
      loginError: null,
      isLoading: false,
      isGoogleLoading: false,
      error: {},
      requestError: null,
      showPassword:false,
      dialog:false,
    };
  },
  methods: {


    showDialogError(){
        this.requestError = 'Error';
    },  
    clearError(){
      console.log('ey');
      this.requestError  = null;
    },
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

    showAuthError() {
      if (this.$route.query.error) {
        this.loginError = this.$route.query.error;
        console.log(this.loginError);
      }
    },

    async loginUser() {
      this.isLoading = true;
      await this.$store
        .dispatch("loginUser", this.form)
        .then((res) => {
          console.log(res.data);
          localStorage.setItem("token", res.data);
          window.location.reload(true);
        })
        .catch((err) => {
          console.log(err);
          if (err.response.status === 422) {
            this.error = err.response.data.errors;
          } else {
            this.requestError = err;
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
