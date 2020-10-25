import Vue from 'vue';
import VueRouter from 'vue-router';

import EventList from "./pages/EventList.vue";
import EventShow from "./pages/EventShow.vue";
import EventCreate from "./pages/EventCreate.vue";
import Login from "./pages/Login.vue";

import store from './store';
import SystemError from './pages/errors/System.vue'

// VueRouterプラグイン使用<RouterView />を利用可能にできる
Vue.use(VueRouter)

// パスとコンポーネントのマッピング
const routes = [
  // {
  //   path: '/login',
  //   name: 'login',
  //   component: Login,
  //   beforeEnter(to, from, next) {
  //     if(store.getters['auth/check']) {
  //       next('/')
  //     } else {
  //       next()
  //     }
  //   }
  // },
  {
    path: '/',
    name: 'event.list',
    component: EventList,
  },
  {
    path: '/events/:id',
    name: 'event.show',
    component: EventShow,
    props: true
  },
  {
    path: '/events/create',
    name: 'event.create',
    component: EventCreate,
  },
  {
    path: '/500',
    component: SystemError
  }
]

// VuewRouterインスタンスを作成する
const router = new VueRouter({
    mode: 'history',
    routes
})

// app.jsにエクスポートする
export default router
