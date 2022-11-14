

import './bootstrap';
import { createApp } from 'vue';
import VueAxios from 'vue-axios';
import VueSocialauth from 'vue-social-auth';

// COMPONENTS
import App from './App.vue';
import BaseSpinner from './components/BaseSpinner.vue';
import BaseButton from './components/BaseButton.vue';
import GoogleButton from './components/GoogleButton.vue';
import BaseScreenLoading from './components/BaseScreenLoading.vue';

import router from './router/router';
import store from './store/store';

// USE

const app = createApp({});
app.use(router);
app.use(store);
app.use(VueAxios,axios);

// GLOBAL COMPONENT 
app.component('App', App);
app.component('base-spinner', BaseSpinner);
app.component('base-button', BaseButton);
app.component('google-button', GoogleButton);
app.component('base-screen-loading', BaseScreenLoading);

app.mount('#app');
