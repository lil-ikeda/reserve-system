import '../bootstrap'
import Vue from 'vue'
import HeaderComponent from './components/HeaderComponent.vue'
import Message from '../components/Message.vue'
import FooterComponent from './components/FooterComponent.vue'
import Modal from './components/Modal.vue'
import Login from './pages/Login'
import Register from './pages/Register'
import EventIndex from './pages/EventIndex'
import EventShow from './pages/EventShow'
import EventEntry from './pages/EventEntry'
import EventEntryConfirm from './pages/EventEntryConfirm'
import EventCancel from './pages/EventCancel'
import EventCancelConfirm from './pages/EventCancelConfirm'
import MyPage from './pages/MyPage'

// fontawesome
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faInstagram } from '@fortawesome/free-brands-svg-icons'
import { faFacebookSquare } from '@fortawesome/free-brands-svg-icons'
import { faTwitter } from '@fortawesome/free-brands-svg-icons'
import { faYoutube } from '@fortawesome/free-brands-svg-icons'
import {faCalendarAlt, faClock, faPaperPlane, faMapMarkerAlt, faUsers} from "@fortawesome/free-solid-svg-icons";
library.add(faInstagram)
library.add(faFacebookSquare)
library.add(faTwitter)
library.add(faYoutube)
library.add(faPaperPlane)
library.add(faCalendarAlt)
library.add(faClock)
library.add(faMapMarkerAlt)
library.add(faUsers)
Vue.component('font-awesome-icon', FontAwesomeIcon)
Vue.config.productionTip = false

// ヘッダー・フッター
Vue.component('header-component', require('./components/HeaderComponent.vue'));
Vue.component('footer-component', require('./components/FooterComponent.vue'));

// フラッシュ非表示用のjQuery
window.jquery = require('jquery');
window.$ = require('jquery');
$('.close-flash').on('click', function() {
  $('.flash-container').addClass('-close');
});

const app = new Vue({
  el: '#app',
  components: {
    HeaderComponent,
    Message,
    FooterComponent,
    Modal,
    Login,
    Register,
    EventIndex,
    EventShow,
    EventEntry,
    EventEntryConfirm,
    EventCancel,
    EventCancelConfirm,
    MyPage
  }
});