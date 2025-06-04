<template>
  <div class="BK">
    <WarnMessage/>
    <IsLoading v-show="isLoading"/>

    <div v-show="!isLoading" class="ObjectBoxFlex PaddingLeftRight">
      <h1>首頁 </h1>
      <button @click="submitHomeForm" type="submit" class="ItemButton">確定更新</button>
    </div>

    <div v-show="!isLoading" class="PaddingLeftRight PaddingBottom">
      <form
        @submit.prevent="submitHomeForm"
        enctype="multipart/form-data"
        class="formGrid"
      >
      <HomeOne
        v-model:bannerIMG     = "bannerIMG"
        v-model:title         = "homeInfo.HomeBannerTitle"
        v-model:buttonText    = "homeInfo.HomeBannerBtn"
        v-model:fileName      = "bannerFileName"
      />

      <HomeTwo
        v-model:title         ="homeInfo.HomeTwoTitle"
      />

      <HomeThree
        v-model:title         = "homeInfo.HomeThreeTitle"
        v-model:content       = "homeInfo.HomeThreeContent"
        v-model:homeThreeIMG  = "homeThreeIMG"
        v-model:btn           = "homeInfo.HomeThreeBtn"
        v-model:fileName      = "homeThreeFileName"
      />
        
      </form>
    </div>
  </div>  
</template>

<script>
import { computed, inject, onMounted, ref } from 'vue';
import IsLoading from '../IsLoading.vue';
import WarnMessage from '../WarnMessage.vue';
import { useStore } from 'vuex';
import HomeOne from './HomeOne.vue';
import HomeTwo from './HomeTwo.vue';
import HomeThree from './HomeThree.vue';
import { eventBus } from '@/eventBus';

export default {
  components:{
    WarnMessage,
    IsLoading,
    HomeOne,
    HomeTwo,
    HomeThree    
  },
  setup(){
    const isLoading = ref(true);
    const store = useStore();
    const apiUrl = inject('apiUrl');

    //獲取vuex獲取vuex
    onMounted(async() => {
      const result = await store.dispatch('HomeStore/fetchDetails');
      if(!result.success){
        eventBus.emit('sentErrorMessage', '載入失敗' + result.message);
      }
        isLoading.value = false;
        window.scroll(0, 0);
    })

    const homeInfo = computed(() =>
      store.getters['HomeStore/getHomeStore'] || {}
    );

    //獲取圖片
    const bannerIMG = computed(() =>
      homeInfo.value.HomeBannerIMG
      ?`${apiUrl}/src/assets/home/${homeInfo.value.HomeBannerIMG}`
      :''
    );

    const homeThreeIMG = computed(() =>
      homeInfo.value.HomeThreeIMG
      ?`${apiUrl}/src/assets/home/${homeInfo.value.HomeThreeIMG}`
      :''
    );

    //管理fileName
    const bannerFileName = ref(null);
    const homeThreeFileName = ref(null);

    //處理submit
    const buildFormData = () =>{
      const formData = new FormData();
      formData.append('HomeOneTitle', homeInfo.value.HomeBannerTitle);
      formData.append('HomeOneBtn', homeInfo.value.HomeBannerBtn);
      formData.append('currentHomeOne_image', homeInfo.value.HomeBannerIMG);
      formData.append('HomeTwoTitle', homeInfo.value.HomeTwoTitle);
      formData.append('HomeThreeTitle', homeInfo.value.HomeThreeTitle);
      formData.append('HomeThreeContent', homeInfo.value.HomeThreeContent);
      formData.append('HomeThreeBtn', homeInfo.value.HomeThreeBtn);
      formData.append('currentHomeThree_image', homeInfo.value.HomeThreeIMG);
      if(bannerFileName.value) formData.append('HomeBannerimage', bannerFileName.value);
      if(homeThreeFileName.value) formData.append('HomeThreeImage', homeThreeFileName.value);
      return formData;
    }

    const submitHomeForm = async () =>{
      isLoading.value = true;
      try{
        const formData = buildFormData();
        const response = await store.dispatch('HomeStore/updateHomePage', formData);

        if(!response || !response.success) {
          eventBus.emit('sentErrorMessage', response?.message || '未知錯誤');
        } else {
          eventBus.emit('sentSuccessMessage',response.message);
          bannerFileName.value = null;
          homeThreeFileName.value = null;
        }
      } catch (error) {
        eventBus.emit('sentErrorMessage', '請求失敗:' + error.message);
      } finally {
        isLoading.value = false;
      }      
    }

    return{
      isLoading,
      homeInfo,
      bannerIMG,
      homeThreeIMG,
      bannerFileName,
      homeThreeFileName,
      submitHomeForm
    }
  }
}
</script>

<style>
</style>