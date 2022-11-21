

import './bootstrap';
import { createApp } from 'vue';
import VueAxios from 'vue-axios';
// SWEET ALERT

import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

// LOTTIE
import Vue3Lottie from 'vue3-lottie';
import 'vue3-lottie/dist/style.css';
//WAVE UI
import WaveUI from 'wave-ui';
import 'wave-ui/dist/wave-ui.css';

// COMPONENTS
import App from './App.vue';
import BaseSpinner from './components/BaseSpinner.vue';
import BaseButton from './components/BaseButton.vue';
import GoogleButton from './components/GoogleButton.vue';
import BaseScreenLoading from './components/BaseScreenLoading.vue';
import BaseHeaderNoButton from './components/welcomepage/BaseHeaderNoButton.vue';
import BaseCardShadow  from './components/BaseCardShadow.vue';
import router from './router/router';
import store from './store/store';
import BaseErrorDialog from './components/dialogs/BaseErrorDialog.vue';
import CustomButton from './components/CustomButton.vue';
import BaseDragFile from './components/BaseDragFile.vue';

// USE

const app = createApp({});
new WaveUI(app, {
    // Some Wave UI options.
 });
app.use(router);
app.use(store);
app.use(VueAxios,axios);
app.use(Vue3Lottie);
app.use(VueSweetalert2);

// GLOBAL COMPONENT 
app.component('App', App);
app.component('base-spinner', BaseSpinner);
app.component('base-button', BaseButton);
app.component('google-button', GoogleButton);
app.component('base-screen-loading', BaseScreenLoading);
app.component('base-header-no-button', BaseHeaderNoButton);
app.component('base-card-shadow', BaseCardShadow);
app.component('base-error-dialog', BaseErrorDialog);
app.component('custom-button', CustomButton);
app.component('base-drag-file', BaseDragFile);

app.mount('#app');
