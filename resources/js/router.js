import Vue from 'vue';
import VueRouter from 'vue-router';

import EventList from "./pages/EventList.vue";
import EventShow from "./pages/EventShow.vue";
import Login from "./pages/Login.vue";


// VueRouterプラグイン使用<RouterView />を利用可能にできる
Vue.use(VueRouter)

// パスとコンポーネントのマッピング
const routes = [
    {
      path: '/',
      name: 'event.list',
      component: EventList,
    },
    {
      path: '/login',
      name: 'login',
      component: Login,
    },
    {
      path: '/events/:eventId',
      name: 'event.show',
      component: EventShow,
      props: true
    }
]

// VuewRouterインスタンスを作成する
const router = new VueRouter({
    mode: 'history',
    routes
})

// app.jsにエクスポートする
export default router