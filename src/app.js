import 'bulma/css/bulma.css';

import Vue from 'vue';
import VueResource from 'vue-resource';
import VueRouter from 'vue-router';
import VueEvents from 'vue-events';

import Profile from './vue/profile.vue';
import Friends from './vue/friends.vue';
import Login from './vue/login.vue';
import Register from './vue/register.vue';
const NotFoundComponent = { template: '<p>404</p>' };

Vue.use(VueResource);
Vue.use(VueRouter);
Vue.use(VueEvents);

//const baseDir = '/cinf201/a10';
//const baseDir = '/projects/school/cinf201/a10';
const baseDir = '/cinf201fa2016/cmdaly';

const routes = [
  { path: '/', component: Profile },
  { path: '/profile/:user?', component: Profile },
  { path: '/friends/', component: Friends },
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '*', component: NotFoundComponent }
];

const router = new VueRouter({
  mode: 'history',
  base: baseDir,
  routes // short for routes: routes
});

window.phpLocation = baseDir + '/src/php/';

const app = new Vue({
  router
}).$mount('#main');
