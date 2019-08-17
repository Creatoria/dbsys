import Vue from "vue";
import App from "./App.vue";
import router from "./router/router";
import store from "./store/store";
import './plugins/element.js'
import axios from 'axios'
import VueAxios from 'vue-axios'

Vue.config.productionTip = false;
Vue.prototype.$ajax = axios;
new Vue({
  el: "#app",
  router,
  store,
  VueAxios,
  axios,
  render: h => h(App)
});