<template>
  <div class="BK">
    <WarnMessage/>
    <IsLoading v-show="isLoading"/>
    
    <div v-show="!isLoading" class="ObjectBoxFlex PaddingLeftRight">
      <h1>{{ navbarName }}</h1>
      <button @click="submitForm" type="submit" class="ItemButton">確定更新</button> 
    </div>
    
    <div v-show="!isLoading" class="PaddingLeftRight PaddingBottom">
      <form @submit.prevent="submitForm" enctype="multipart/form-data" class="formGrid">
        <table class="RouterPage">
          <thead>
            <tr class="ObjectBox ObjectBoxBoerderBottom">
              <th class="TitleH3">文章部分</th>
            </tr>
          </thead>
          
          <tbody class="ObjectBox ObjectGrid">
            <tr class="ObjectItem">
              <td>標題</td>
              <td>
                <input type="text" v-model="localJoinInfo.JoinTitle" placeholder="這邊輸入標題" class="InputText">
              </td>
            </tr>

            <tr class="ObjectItem">
              <td>內文:</td>
              <td>
                <textarea 
                  v-model="localJoinInfo.JoinContent" 
                  placeholder="這邊輸入內文" 
                  class="InputText"
                ></textarea>
              </td>
            </tr>

            <tr class="ObjectItem">
              <td>按鈕文字</td>
              <td>
                <input 
                  type="text" 
                  v-model="localJoinInfo.JoinBtn" 
                  placeholder="這邊輸入按鈕文字，建議四個字" 
                  class="InputText"
                >
              </td>
            </tr>
          </tbody>
          </table>

          <table class="RouterPage">
            <thead>
              <tr class="ObjectBox ObjectBoxBoerderBottom">
                <th class="TitleH3">背景圖片</th>
              </tr>
            </thead>
            
            <tbody class="ObjectBox ObjectGrid">
              <tr class="ObjectItem">
                <td>目前圖片</td>
                <td>
                  <img v-if="bannerIMG" :src="bannerIMG" width="150px">
                  <div v-else class="errorBold">尚未上傳圖片</div>
                </td>
              </tr>
              
              <tr class="ObjectItem">
                <td>選擇圖片</td>
                <td>
                  <input 
                    class="fileInput" 
                    id="fileInput"
                    type="file" 
                    @change="handleFileUpload"
                  >
                  <label 
                    type="button" 
                    for="fileInput"
                    class="ItemButton" 
                  >選擇圖片</label>
                  <div class="Font14">{{ fileName || '尚未更換圖片' }}</div>
                </td>
              </tr>
            </tbody>          
        </table>
      </form>
    </div>  
  </div>
</template>

<script>
import { computed, inject, onMounted, ref } from 'vue';
import { useStore } from 'vuex';
import IsLoading from '../IsLoading.vue';
import WarnMessage from '../WarnMessage.vue';
import { eventBus } from '@/eventBus';

export default {
  components:{
    IsLoading,
    WarnMessage,
  },
  setup(){
    const store           = useStore();
    const apiUrl          = inject('apiUrl');
    const isLoading       = ref(true);
    const fileName        = ref('');
    const selectedImage   = ref(null);
    const localJoinInfo   = ref({
      JoinTitle: '',
      JoinContent: '',
      JoinBtn: '',
    });

    //獲取Vuex
    onMounted(async () => {
      const result = await store.dispatch('JoinStore/fetchDetails');
      if(result.success){
        localJoinInfo.value = {
          JoinTitle: joinInfo.value.JoinTitle,
          JoinContent: joinInfo.value.JoinContent,
          JoinBtn: joinInfo.value.JoinBtn,
        };
      }else{
        eventBus.emit('sentErrorMessage', '載入失敗' + result.message);
      }
      isLoading.value = false;
      window.scroll(0, 0);
    });
    const joinInfo = computed(() => store.getters['JoinStore/getJoinStore']);
    const navbarName = computed(()=> store.getters['WebsiteInformation/getNavbarThreeName']);

    //獲取圖片
    const bannerIMG = computed(() =>
    joinInfo.value.JoinIMG
    ?`${apiUrl}/src/assets/join/${joinInfo.value.JoinIMG}`
    :''
  );

  //處理圖片上傳
  const handleFileUpload = (event) =>{
    selectedImage.value = event.target.files[0];
    fileName.value = selectedImage.value ? selectedImage.value.name : '';
  }

  const buildFormData = () =>{
    const formData = new FormData();
    formData.append('Title', localJoinInfo.value.JoinTitle);
    formData.append('Content', localJoinInfo.value.JoinContent);
    formData.append('btnText', localJoinInfo.value.JoinBtn);
    formData.append('current_image', joinInfo.value.JoinIMG);
    if (selectedImage.value) formData.append('image', selectedImage.value);
    return formData
  }

  const submitForm = async () => {
    isLoading.value = true;
    try{
      const formData = buildFormData();
      const response = await store.dispatch('JoinStore/updateJoinPage', formData);

      if (!response || !response.success) { 
        eventBus.emit('sentErrorMessage', response.message || '未知錯誤')
      } else {
        eventBus.emit('sentSuccessMessage',response.message)
        fileName.value = '';
        selectedImage.value = null;
      }
    }catch(error){
      eventBus.emit('sentErrorMessage', '請求失敗:' + error.message);
    }finally{
      isLoading.value = false;
    }
  };

    return{
      localJoinInfo,
      bannerIMG,
      isLoading,
      handleFileUpload,
      fileName,
      submitForm,
      navbarName
    }
  }
}
</script>

<style>
</style>