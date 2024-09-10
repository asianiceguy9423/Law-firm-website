import Vue from 'vue'
import App from './App.vue'
import router from './router/router'
import AOS from 'aos';
import "aos/dist/aos.css";

// Import the FontAwesome core
import { library } from '@fortawesome/fontawesome-svg-core';

// Import FontAwesome Icon component
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

// Import specific icons
import { fas } from '@fortawesome/free-solid-svg-icons';
import { far } from '@fortawesome/free-regular-svg-icons';
import { fab } from '@fortawesome/free-brands-svg-icons';


// Add icons to the library
library.add(fas, far, fab);

// Register the component globally
Vue.component('font-awesome-icon', FontAwesomeIcon);
//api url

// Vue.prototype.$apiurl = process.env.NODE_ENV === 'production' ? 'http://laucho.atwebpages.com' : 'http://localhost/website1/';
// Vue.prototype.$imgurl = 'http://laucho.atwebpages.com/img';

Vue.prototype.$apiurl = process.env.NODE_ENV === 'production' ? 'http://lauchobackstage.zya.me' : 'http://localhost/website1/';
Vue.prototype.$imgurl = 'http://lauchobackstage.zya.me/img';

Vue.config.productionTip = false

new Vue({
  render: h => h(App),
  router,
  created() {
    AOS.init();
  },
  beforeCreate(){
    Vue.prototype.$bus = this
  }
}).$mount('#app')
