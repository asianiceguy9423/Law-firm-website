<template>
  <IsLoading  v-if="!isReady"/>
  <div v-else>
    <AboutBanner
      :bannerIMG      = "bannerIMG"
      :title          = "aboutInfo.AboutBannerTitle"
    />

    <AboutTwo
      :title          = "aboutInfo.AboutTwoTitle"
      :content        = "aboutInfo.AboutTwoContent"
      :personIMG      = "personIMG"
    />

    <AboutThree
      :BK      = "AboutThreeBKIMG"
    />
  </div> 
</template>

<script>
import { useStore } from 'vuex';
import AboutBanner from './AboutBanner.vue';
import { computed, inject, onMounted } from 'vue';
import AboutTwo from './AboutTwo.vue';
import AboutThree from './AboutThree.vue';
import { getIMGUrl, getRGB } from '@/utils/tools';
import IsLoading from '../IsLoading.vue';

export default {
  components:{
    AboutBanner,
    AboutTwo,
    AboutThree,
    IsLoading,
  },
  setup() {
    const store   = useStore();
    const apiUrl  = inject('apiUrl');
    const isReady = computed(()=>
      bannerIMG.value &&
      personIMG.value &&
      AboutThreeBKIMG.value &&
      aboutInfo.value
    );

    //獲取vuex
    onMounted( async() => {
      await Promise.all([
        store.dispatch('AboutStore/fetchDetails'),
      ]);
      window.scroll(0, 0);
    });

    const aboutInfo = computed(() => store.getters['AboutStore/getAboutStore']);

    //獲取圖片

    const bannerIMG = computed(() => 
    getIMGUrl(apiUrl, 'about', aboutInfo.value.AboutBannerIMG)
    );

    const personIMG = computed(() => 
      getIMGUrl(apiUrl, 'about', aboutInfo.value.AboutPersonIMG)
    );

    const AboutThreeBKIMG = computed(() =>
      getIMGUrl(apiUrl, 'about', aboutInfo.value.AboutThreeBKIMG)
    );

    return{
      aboutInfo,
      bannerIMG,
      personIMG,
      AboutThreeBKIMG,
      getRGB,
      isReady,
    }
  }
}
</script>

<style>
</style>