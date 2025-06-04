<template>
  <IsLoading  v-if="!isReady"/>
  <div v-else>
    <div class="HomeOne">
      <HomeBanner
        :bannerIMG      = "bannerIMG"
        :title          = "homeInfo.HomeBannerTitle"
        :buttonText     = "homeInfo.HomeBannerBtn"
      />
    </div>  

    <HomeTwo
      :navbarOptions  = "websiteInfo.navbarOptions" 
      :title          = "homeInfo.HomeTwoTitle"
    />

    <HomeThree
      :image          = "homeThreeIMG"
      :content        = "homeInfo.HomeThreeContent"
      :buttonText     = "homeInfo.HomeThreeBtn"
      :title          = "homeInfo.HomeThreeTitle"
    />
  </div>
</template>

<script>
import { computed, inject, onMounted } from 'vue';
import { useStore } from 'vuex';
import HomeBanner from './HomeBanner.vue';
import HomeTwo from './HomeTwo.vue';
import HomeThree from './HomeThree.vue';
import { getIMGUrl, getRGB } from '@/utils/tools';
import IsLoading from '../IsLoading.vue';
export default {
  components:{
    HomeBanner,
    HomeTwo,
    HomeThree,
    IsLoading,
  },
  setup() {
    const store   = useStore();
    const apiUrl  = inject('apiUrl');
    const isReady = computed(()=>
      bannerIMG.value &&
      homeThreeIMG.value &&
      homeInfo.value &&
      websiteInfo.value
    );
    
    //獲取vuex
    onMounted(async() =>{
      store.dispatch('HomeStore/fetchDetails');
      store.dispatch('WebsiteInformation/fetchDetails');
      window.scroll(0, 0);
    });
    const homeInfo = computed(() =>store.getters['HomeStore/getHomeStore']);
    const websiteInfo = computed(() => store.getters['WebsiteInformation/getWebsiteInformations']);
    
    //獲取圖片      
    const bannerIMG = computed(() => 
      getIMGUrl(apiUrl, 'home', homeInfo.value.HomeBannerIMG)
    );

    const homeThreeIMG = computed(() =>
      getIMGUrl(apiUrl, 'home', homeInfo.value.HomeThreeIMG)
    );

    return {
      homeInfo,
      bannerIMG,
      homeThreeIMG,
      websiteInfo,
      getRGB,
      isReady,
    }
  }
}
</script>

<style lang="scss" scoped>
.HomeOne{
  background-color: rgb(0, 0, 0);
}
</style>