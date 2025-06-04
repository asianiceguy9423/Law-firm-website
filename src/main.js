import { createApp } from 'vue';
import App from './App.vue';
import { createCustomStore } from './store'; // 引入工廠函數
import router from './router'; // 引入 router
import axios from 'axios'; // 引入 axios
import VueLazyload from 'vue-lazyload'; //引入 v-lazy

const app = createApp(App);

// 定義全局 apiUrl
const apiUrl = process.env.NODE_ENV === 'production'
  ? 'http://simulation4516423.medianewsonline.com'
  : 'http://localhost/fornt_back_website';

  app.provide('apiUrl',apiUrl);

// 創建 store 並傳遞 apiUrl
const store = createCustomStore(apiUrl);

app.use(store);
app.use(router);
app.use(VueLazyload,{
  preLoad: 1.3, //提前加載距離
  error: '',//加載失敗顯示佔位圖
  loading: '', //加載中顯示佔位圖
  attempt: 1, //嘗試加載次數
})
app.config.globalProperties.$axios = axios;
app.config.globalProperties.$apiurl = apiUrl;

app.mount('#app');
