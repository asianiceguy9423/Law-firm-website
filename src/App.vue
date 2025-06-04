<template>
  <router-view/>
</template>

<script>
import AOS from 'aos';
import 'aos/dist/aos.css';
import { onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';

export default {
  name: 'App',
  setup(){
    const route = useRoute(); // 導入 Vue Router 的當前路由
    //AOS設定
    onMounted(() => {
      AOS.init(
        {
          duration: 1600,
          once: true,
          easing: 'ease-in-out',
          offset: 120,
        }
      )
    })

    // 監聽路由變化，刷新 AOS
    watch(route, () => {
      AOS.refresh(); // 確保動畫仍有效
    })
  }
}
</script>

<style>
* {
  margin: 0;
  padding: 0;
  font-family: Arial, Helvetica, sans-serif;
  text-decoration: none;
  list-style: none;
}
h1{
font-size: 32px;
}
p{
  font-size: 18px;
  line-height: 1.6;
}
a{
  font-size: 18px;
}

@media (max-width: 1250px){
  h1{
  font-size: 28px;
  }
  p{
    font-size: 16px;
    line-height: 1.7;
  }
  a{
    font-size: 16px;
  }
}

@media (max-width: 768px){
  h1{
  font-size: 28px;
  }
  p{
    font-size: 16px;
    line-height: 1.7;
  }
  a{
    font-size: 16px;
  }
}

</style>