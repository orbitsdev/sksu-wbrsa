



import axiosApi from "../../../api/axiosApi";

import axios from "axios";
export default {


   async getUserDetails(commit, token){
    axios.defaults.headers.common['Authorization']= "Bearer "+token;


      const response = await  axios.get('api/user');

      return response;

    },

    logoutUser({commit}){
    
        commit('setUser',{user: null, token: null});
    },

    async logInWithSocialAccount(){
      return axios.get('/api/authorize/google/redirect').then(res=>{
        return res;
      }).catch(err=>{
        throw new Error(err);
      })
    }

    

}