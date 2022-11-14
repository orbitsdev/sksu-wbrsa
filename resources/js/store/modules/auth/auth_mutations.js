





export default {

    setUserDetails(state, payload){
        
        state.user = {
            user: payload.user,
            roles: payload.roles,
            token: payload.token,
        };
        


    }

   

}