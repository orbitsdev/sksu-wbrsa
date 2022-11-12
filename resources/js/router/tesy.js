import Vue from 'vue'
import router from './router';
import store from './store';
import NProgress from 'nprogress';
import 'nprogress/nprogress.css';
import './helper/axios'

router.beforeEach((to, from, next) => {
  NProgress.start();
  if (to.meta.loginRequired && to.meta.loginRequired === true) {
    const token = localStorage.getItem('token');
    if (!token) {
      next({ path: '/login' });
    } else {
      store.dispatch('GetInfo', token).then(res => {
      store.commit('setAdmin', res.data.user.default_user_company.role)

        if (to.meta.disallowed) {
          const role = res.data.user.default_user_company.role;
          const check_role = to.meta.disallowed.filter(roles => roles.includes(role));
          if (check_role.length > 0) {
            next({ path: '/401' });
          } else {
            next();
          }
        } else {
          next();
        }
      }).catch(err => {
        console.log(err)
        store.dispatch('FedLogOut').then(() => {
          console.log(err);
          next({ path: '/login?error=failed' });
        })
      });
    }
  } else {
    next();
  }
});

router.afterEach((to) => {
  Vue.nextTick(() => {
    document.title = to.meta.title || "eUniversityPRO";
  });
  NProgress.done();
});