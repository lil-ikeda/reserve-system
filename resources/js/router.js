import Vue from 'vue';
import VueRouter from 'vue-router';

import EventList from "./pages/EventList.vue";
import EventShow from "./pages/EventShow.vue";
import EventEntry from "./pages/EventEntry.vue";
import EventEntryConfirm from "./pages/EventEntryConfirm.vue";
import EventCancel from "./pages/EventCancel.vue";
import EventCancelConfirm from "./pages/EventCancelConfirm.vue";
import EventPaymentPaypay from "./pages/EventPaymentPaypay.vue";
import Login from './pages/Login.vue';
import store from './store';
import SystemError from './pages/errors/System.vue'
import RegisterMail from "./pages/RegisterMail";

// VueRouterプラグイン使用<RouterView />を利用可能にできる
Vue.use(VueRouter)

// パスとコンポーネントのマッピング
const routes = [
    {
        path: '/login',
        name: 'login',
        component: Login,
        beforeEnter(to, from, next) {
            if (store.getters['auth/check']) {
                next('/')
            } else {
                next()
            }
        }
    },
    {
        path: '/register/mail',
        name: 'register.mail',
        component: RegisterMail,
    },
    // イベント関連
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
        path: '/events/:id/entry',
        name: 'event.entry',
        component: EventEntry,
        props: true
    },
    {
        path: '/events/:id/entry/confrim',
        name: 'event.entry.confirm',
        component: EventEntryConfirm,
        props: true
    },
    {
        path: '/events/:id/cancel',
        name: 'event.cancel',
        component: EventCancel,
        props: true
    },
    {
        path: '/events/:id/cancel/confirm',
        name: 'event.cancel.confirm',
        component: EventCancelConfirm,
        props: true
    },
    {
        path: 'events/:id/payment/paypay',
        name: 'event.payment.paypay',
        component: EventPaymentPaypay,
        props: true
    },
    // エラー画面
    {
        path: '/500',
        component: SystemError
    }
]

// VuewRouterインスタンスを作成する
const router = new VueRouter({
    mode: 'history',
    routes
});

// app.jsにエクスポートする
export default router
