<template>
  <div class="BK">
    <WarnMessage/>
    <IsLoading v-show="isLoading"/>
  
    <div v-show="!isLoading" class="ObjectBoxFlex PaddingLeftRight">
      <h1>網站設定</h1>
      <button @click="submitForm" type="submit" class="ItemButton">確定更新</button> 
    </div>
  
    <div class="PaddingLeftRight PaddingBottom">
      <form @submit.prevent="submitForm" enctype="multipart/form-data" class="formGrid">
        <BasicInfoColor 
           v-model:websiteColor     = "websiteColor"
           @update:websiteColor     = "updateWebsiteColor"
        />
        <BasicNavbarName
          v-model:navbarMainOption  = "navbarMainOption"
          @update:navbarMainOption  = "updateNavbarMainOption"
        />
      </form>
    </div>  
  </div>
</template>

<script>
import { useStore } from 'vuex';
import IsLoading from '../IsLoading.vue';
import WarnMessage from '../WarnMessage.vue';
import { computed, onMounted, ref } from "vue";
import BasicInfoColor from './BasicInfoColor.vue';
import { eventBus } from '@/eventBus';
import BasicNavbarName from './BasicNavbarName.vue';

export default {
  components:{
    IsLoading,
    WarnMessage,
    BasicInfoColor,
    BasicNavbarName,
  },
  setup() {
    const store       = useStore();
    const isLoading   = ref(true);
    const websiteColor = ref([]); // ✅ 修正：獨立 `websiteColor` 作為響應數據
    const navbarMainOption = ref([]);

    // ✅ **修正 `updateWebsiteColor` 確保正確更新顏色**
    const updateWebsiteColor = (newColor) => {
      websiteColor.value = [...newColor]; // ✅ **確保響應性**
    };

    const updateNavbarMainOption = (newOption) => {
      navbarMainOption.value = [...newOption];
    }

    const websiteInfo = computed(() => store.getters['WebsiteInformation/getWebsiteInformations']);

    onMounted(async () =>{
      await store.dispatch('WebsiteInformation/fetchDetails');
      isLoading.value = false;
      if (websiteInfo.value.colorChart.length) {
        updateWebsiteColor(websiteInfo.value.colorChart);
      }
      if (websiteInfo.value.navbarMainOption.length) {
        updateNavbarMainOption(websiteInfo.value.navbarMainOption);
      }
      window.scroll(0,0);
    });

    //處理送出
    const submitForm = async() => {
      // if (!websiteColor.value || !Array.isArray(websiteColor.value) || websiteColor.value.length === 0) {
      //   console.error("❌ `websiteColor` 是空的，無法送出！");
      //   eventBus.emit('sentErrorMessage', '顏色數據錯誤，請重新設定');
      //   return;
      // }

      const formData = new FormData();
      formData.append('BasicColor', JSON.stringify(websiteColor.value));
      formData.append('NavbarMainOption', JSON.stringify(navbarMainOption.value));
      // console.log("✅ 送出的 `BasicColor` JSON:", JSON.stringify(navbarMainOption.value, null, 2));

      const response = await store.dispatch('WebsiteInformation/updateColor', formData);

      if (response.success) {
        store.commit("WebsiteInformation/RESET_COLOR_STATE");
        await store.dispatch("WebsiteInformation/fetchDetails");
      }

      if (!response || !response.success) {
        eventBus.emit('sentErrorMessage', response?.message || '未知錯誤');
      } else {
        eventBus.emit('sentSuccessMessage', response.message);
      }
    };
    
    return { 
      isLoading,
      websiteInfo,
      websiteColor,
      submitForm,
      updateWebsiteColor, 
      navbarMainOption,
      updateNavbarMainOption,
    };
  },
};
</script>

<style >
</style>