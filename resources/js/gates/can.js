



import store from '../store/store';

export default (roles)=>{
    
    const user_roles = store.getters['user'].roles; 
    return user_roles.length && user_roles.includes(roles);

}