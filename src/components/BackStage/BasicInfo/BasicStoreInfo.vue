<template>
  <div class="BK">
    <WarnMessage/>
    <IsLoading v-show="isLoading"/>
  
    <div v-show="!isLoading" class="ObjectBoxFlex PaddingLeftRight">
      <h1>店家資訊設定</h1>
      <button @click="submitForm" type="submit" class="ItemButton">確定更新</button> 
    </div>
  
    <div class="PaddingLeftRight PaddingBottom">
      <form @submit.prevent="submitForm" enctype="multipart/form-data" class="formGrid">
        <BasicStoreLogo
        :logoIMG       = "logoIMG"
        v-model:logoFileName  = "logoFileName"
        />
        <BasicStoreInfoSide
          v-model:storeInfo = "storeInfo"
          @update:storeInfo = "updateStoreInfo"
        />
        <BasicStoreInfoLink
          v-model:storeLink = "storeLink"
          @update:storeLink = "updatedStoreLink"
        />
      </form>
    </div>  
  </div>  
</template>

<script>
import { useStore } from 'vuex';
import IsLoading from '../IsLoading.vue';
import WarnMessage from '../WarnMessage.vue';
import BasicStoreInfoLink from './BasicStoreInfoLink.vue';
import BasicStoreInfoSide from './BasicStoreInfoSide.vue';
import { computed, inject, onMounted, ref } from 'vue';
import BasicStoreLogo from './BasicStoreLogo.vue';
import { eventBus } from '@/eventBus';

export default {
  components:{
    BasicStoreLogo,
    BasicStoreInfoSide,
    BasicStoreInfoLink,
    WarnMessage,
    IsLoading,
  },
  setup(){
    const store             = useStore();
    const apiUrl            = inject('apiUrl');
    const isLoading         = ref(true);
    const storeInfo         = ref([]);
    const storeLink         = ref([]);
    const updateStoreInfo   = (newInfo) => {
      storeInfo.value       = [...newInfo]
    }
    const updatedStoreLink  = (newInfo) => {
      storeLink.value       = [...newInfo]
    }

    const websStoreInfo = computed(() => store.getters['WebsiteInformation/getStoreInformations'])

    onMounted(async () =>{
      const result = await store.dispatch('WebsiteInformation/fetchDetails');
      if(!result.success) {
        eventBus.emit('sentErrorMessage', '載入失敗' + result.message);
      }
      if (websStoreInfo.value.storeInfo.length && websStoreInfo.value.LinkInfo.length) {
        updateStoreInfo(websStoreInfo.value.storeInfo);
        updatedStoreLink(websStoreInfo.value.LinkInfo);
      }
      isLoading.value = false;
      window.scroll(0,0);
    })

    //獲取圖片
    const logoIMG = computed(() =>
      websStoreInfo.value.currentLOGO
      ?`${apiUrl}/src/assets/basic/${websStoreInfo.value.currentLOGO}`
      :''
    );
    //管理fileName
    const logoFileName = ref(null);

    //處理送出
    const refreshMemberList = async() =>{
      const formData = new FormData();
      formData.append('StoreInfo', JSON.stringify(storeInfo.value));
      if(logoFileName.value) formData.append('BasicLogo_image',logoFileName.value);
      return formData;
    }

    const submitForm = async() => {
      isLoading.value = true;
      try{
        const formData = await refreshMemberList(); 
        const response = await store.dispatch(
          'WebsiteInformation/updateBasicInfo', 
          formData
        );

        if(response.success){
          store.commit("WebsiteInformation/RESET_LOGO_STATE");
          await store.dispatch('WebsiteInformation/fetchDetails');
        }
        if(!response || !response.success){
          eventBus.emit('sentErrorMessage', response?.message || '未知錯誤')
        } else {
          eventBus.emit('sentSuccessMessage',response.message)
        }
      }catch(error){
        eventBus.emit('sentErrorMessage', '請求失敗:' + error.message);
      }finally{
        isLoading.value = false;
      }
    }

    return{
      isLoading,
      websStoreInfo,
      updateStoreInfo,
      updatedStoreLink,
      submitForm,
      storeInfo,
      storeLink,
      logoIMG,
      logoFileName,
    }
  }
}
</script>

<style>
</style>