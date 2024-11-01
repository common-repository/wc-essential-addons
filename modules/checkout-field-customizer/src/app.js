import Vue from "vue";
import vmodal from 'vue-js-modal';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
// window.axios = require('axios');
// window.Qs = require('qs');

Vue.use(vmodal)
Vue.use(VueSweetalert2);

Vue.component("App", require("./components/App.vue").default);

new Vue({
    el: "#cfc-vue"
});
