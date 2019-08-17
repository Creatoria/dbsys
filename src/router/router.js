import Vue from "vue";
import Router from "vue-router";
//import Home from "./views/Home.vue";

Vue.use(Router);
import login from "../views/login.vue";
import index from "../views/index.vue";
export default new Router({
  mode: "history",
  base: process.env.BASE_URL,
  routes: [
    // {
    //   path: "/",
    //   name: "home",
    //   component: Home
    // },
    // {
    //   path: "/about",
    //   name: "about",
    //   // route level code-splitting
    //   // this generates a separate chunk (about.[hash].js) for this route
    //   // which is lazy-loaded when the route is visited.
    //   component: () =>
    //     import( /* webpackChunkName: "about" */ "./views/About.vue")
    // },
    {
      path: "/login",
      name: "login",
      component: login
    }, 
    {
      path: "/",
      name: "index",
      component: index
    }
  ]
});
