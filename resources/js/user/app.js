import '../bootstrap'
import Vue from 'vue'
import HeaderComponent from './components/HeaderComponent.vue'
import Message from '../components/Message.vue'
import FooterComponent from './components/FooterComponent.vue'
import Login from './pages/Login'
import EventIndex from './pages/EventIndex'
import EventShow from './pages/EventShow'

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

Vue.component('header-component', require('./components/HeaderComponent.vue'));
Vue.component('footer-component', require('./components/FooterComponent.vue'));


const app = new Vue({
  el: '#app',
  components: {
    HeaderComponent,
    Message,
    FooterComponent,
    Login,
    EventIndex,
    EventShow
  }
});