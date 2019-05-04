import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
// import VueRouter from 'vue-router';
import './plugins/element.js'
import About from './views/About.vue';
import Home from './views/Home.vue';
Vue.config.productionTip = false;

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount("#app");