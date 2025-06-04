<template>
  <div class="BK">
    <WarnMessage/>
    <IsLoading v-show="isLoading"/>

    <div v-show="!isLoading" class="ObjectBoxFlex PaddingLeftRight">
      <h1>{{ navbarName }}</h1>
      <button @click="submitContactForm" type="submit" class="ItemButton">確定更新</button>
    </div>

    <div v-show="!isLoading" class="PaddingLeftRight PaddingBottom">
      <form
        @submit.prevent="submitContactForm"
        enctype="multipart/form-data"
        class="formGrid"
      >
      <ContactOne
        v-model:bannerIMG     = "bannerIMG"
        v-model:bannerTitle   = "ContactInfo.BannerTitle"
        v-model:title         = "ContactInfo.Title"
        v-model:fileName      = "bannerFileName"
      />
      <ContactThree
        v-model:infoDetails      = "ContactInfo.InfoDetails"
      />

      </form>
    </div>
  </div>  
</template>

<script>
import { useStore } from 'vuex';
import IsLoading from '../IsLoading.vue';
import WarnMessage from '../WarnMessage.vue';
import ContactOne from './ContactOne.vue';
import ContactThree from './ContactThree.vue';
import { computed, inject, onMounted, ref } from 'vue';
import { eventBus } from '@/eventBus';

export default {
  components:{
    WarnMessage,
    IsLoading,
    ContactOne,
    ContactThree,
  },
  setup(){
    const isLoading = ref(true);
    const store     = useStore();
    const apiUrl    = inject('apiUrl');

    //獲取vuex
    const ContactInfo = computed(() => store.getters['ContactStore/getContactStore'])

    onMounted(async() =>{
      const bannerResult = await store.dispatch('ContactStore/fetchContactBanner');
      const infoResult = await store.dispatch('ContactStore/fetchContactStoreInfo');
      if(!bannerResult.success){
        eventBus.emit('sentErrorMessage', '載入失敗' + bannerResult.message);
      }
      if(!infoResult.success){
        eventBus.emit('sentErrorMessage', '載入失敗' + infoResult.message);
      }
      isLoading.value = false;
      window.scroll(0, 0);
    })

    const navbarName = computed(()=> store.getters['WebsiteInformation/getNavbarFourName']);

    //獲取圖片
    const bannerIMG = computed(() =>
      ContactInfo.value.BannerIMG
      ?`${apiUrl}/src/assets/contact/${ContactInfo.value.BannerIMG}`
      :''
    );
    //管理fileName
    const bannerFileName = ref(null);

    //處理送出
    const submitContactForm = async () =>{
      isLoading.value = true;
      const formData  = new FormData();
      formData.append('BannerTitle',  ContactInfo.value.BannerTitle);
      formData.append('Title',  ContactInfo.value.Title);
      if(bannerFileName.value){
        formData.append('BannerING',  bannerFileName.value);
      }

      const response  = await store.dispatch('ContactStore/updateContactInfo', formData);

      if(!response || !response.success) {
        eventBus.emit('sentErrorMessage', response?.message || '未知錯誤')
      } else {
        eventBus.emit('sentSuccessMessage',response.message)
      }

      isLoading.value = false;
    }

    return{
      isLoading,
      ContactInfo,
      bannerIMG,
      bannerFileName,
      submitContactForm,
      navbarName,
    }
  }
}
</script>

<style>

</style>