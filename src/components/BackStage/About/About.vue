<template>
  <div class="BK">
    <WarnMessage/>
    <IsLoading v-show="isLoading"/>

    <div v-show="!isLoading" class="ObjectBoxFlex PaddingLeftRight">
      <h1>{{ navbarName }}</h1>
      <button @click="submitAbout" type="submit" class="ItemButton">確定更新</button> 
    </div>

    <div v-show="!isLoading" class="PaddingLeftRight PaddingBottom">
      <form  @submit.prevent="submitAbout" enctype="multipart/form-data" class="formGrid">
        <AboutOne
          v-model:title       = "aboutInfo.AboutBannerTitle"
          :bannerIMG   = "bannerIMG"
          v-model:fileName    = "bannerFileName"
        />
        
        <AboutTwo
          v-model:title       = "aboutInfo.AboutTwoTitle"
          v-model:content     = "aboutInfo.AboutTwoContent"
          :personIMG   = "PersonIMG"
          v-model:fileName    = "PersonFileName"
        />

        <AboutThree
          :BKIMG       = "ThreeBKIMG"
          v-model:aboutMember = "aboutInfo.AboutMember"
          v-model:fileName    = "ThreeBKFileName"
        />

        <AboutMember 
          :key="forceRenderKey"
        />
      </form>
    </div>
  </div>
</template>

<script>
import { useStore } from 'vuex';
import IsLoading from '../IsLoading.vue';
import WarnMessage from '../WarnMessage.vue';
import AboutOne from './AboutOne.vue';
import AboutThree from './AboutThree.vue';
import AboutTwo from './AboutTwo.vue';
import { computed, inject, onMounted, onUnmounted, ref } from 'vue';
import AboutMember from './AboutMember.vue';
import { eventBus } from '@/eventBus';

export default {
  components:{
    WarnMessage,
    IsLoading,
    AboutOne,
    AboutTwo,
    AboutThree,
    AboutMember
  },
  setup(){
    const isLoading = ref(true);
    const store = useStore();
    const apiUrl = inject('apiUrl');
    const forceRenderKey = ref(0); // 🔥 新增強制重新渲染 key

    //獲取vuex
    onMounted(async() =>{
      const result = await store.dispatch('AboutStore/fetchDetails');
      if(!result.success){
        eventBus.emit('sentErrorMessage', '載入失敗' + result.message);
      }      
      isLoading.value = false;
      window.scroll(0, 0);
      eventBus.on('fetchAboutMember', updateMemberList);
    })

    onUnmounted(() => {
      eventBus.off('fetchAboutMember', updateMemberList);
    });

    const navbarName = computed(()=> store.getters['WebsiteInformation/getNavbarOneName'])

    // 強制 AboutMember 重新加載
    const updateMemberList = () => {
      forceRenderKey.value++;
    };

    const aboutInfo = computed(() =>
    store.getters['AboutStore/getAboutStore']
  )

  //獲取圖片
  const getImage = (filename) =>
    filename ? `${apiUrl}/src/assets/about/${filename}` : '';

  const bannerIMG = computed(() =>
    getImage(aboutInfo.value.AboutBannerIMG));

  const PersonIMG = computed(() =>
    getImage(aboutInfo.value.AboutPersonIMG));

  const ThreeBKIMG = computed(() =>
    getImage(aboutInfo.value.AboutThreeBKIMG));

  //管理fileName
  const bannerFileName = ref(null);
  const PersonFileName = ref(null);
  const ThreeBKFileName = ref(null);

  const buildFormData = () =>{
    const formData = new FormData();
    formData.append('bannerTitle',JSON.stringify(aboutInfo.value.AboutBannerTitle));
    formData.append('title', aboutInfo.value.AboutTwoTitle);
    formData.append('contnet', aboutInfo.value.AboutTwoContent);
    if(bannerFileName.value) formData.append('bannerFileName', bannerFileName.value);
    if(PersonFileName.value) formData.append('PersonFileName', PersonFileName.value);
    if(ThreeBKFileName.value) formData.append('ThreeBKFileName', ThreeBKFileName.value);
    return formData;
  }

  const submitAbout = async() =>{
    isLoading.value = true;
    try{
      const formData = buildFormData();
      const response = await store.dispatch('AboutStore/updateAboutPage', formData);

      if(!response || !response.success) {
        eventBus.emit('sentErrorMessage', response?.message || '未知錯誤')
      } else {
        eventBus.emit('sentSuccessMessage',response.message)
        bannerFileName.value = null;
        PersonFileName.value = null;
        ThreeBKFileName.value = null;
      }
    }catch(error){
      eventBus.emit('sentErrorMessage', '請求失敗:' + error.message);
    }finally{
      isLoading.value = false;
    }    
  };

    return{
      isLoading,
      aboutInfo,
      bannerIMG,
      PersonIMG,
      ThreeBKIMG,
      bannerFileName,
      PersonFileName,
      ThreeBKFileName,
      forceRenderKey,
      submitAbout,
      navbarName,
    }
  }
}
</script>

<style>
</style>