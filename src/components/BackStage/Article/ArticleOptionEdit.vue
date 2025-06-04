<template>
  <div class="BK">
    <WarnMessage/>
    <IsLoading v-show="isLoading"/>
    <div class="FlexBoxBottom PaddingLeftRight">
      <div>
        <div class="LinkButtonMarginLeft">
          <button @click="goBack" class="PointButton PointMargin" type="button">{{ navbarTwoName }}</button>
          <svg xmlns="http://www.w3.org/2000/svg"  height="14" width="8.75" viewBox="0 0 320 512">
            <path fill="#acafc4" d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/>
          </svg>
          <button class="PointButton" type="button">編輯分類</button>
        </div>
        <h1>編輯分類</h1>
      </div>
      <div>
        <button 
          @click="goBack" 
          type="button" 
          class="ItemButton ItemButtonWhite"
        >
          取消
        </button>
        <button 
          @click="submitArticleOprionEdite" 
          type="submit" 
          class="ItemButton"
        >
          確定更新
        </button>
      </div>
    </div>

    <form @submit.prevent="submitArticleOprionEdite" enctype="multipart/form-data" class="PaddingLeftRight">
      <table class="RouterPage">
        <thead>
          <tr class="ObjectBox ObjectBoxBoerderBottom">
            <th colspan="2" class="TitleH3">輸入信息</th>
          </tr>
        </thead>        
        <tbody class="ObjectBox ObjectGrid">
          <tr class="ObjectItem">
            <td>名稱</td>
            <td>
              <input 
                class="InputText"
                type="text" 
                v-model="localName" 
                placeholder="這邊輸入名稱" 
              >
            </td>
          </tr>
          <tr class="ObjectItem">
            <td>說明</td>
            <td>
              <input 
                class="InputText"
                type="text" 
                v-model="localExplain" 
                placeholder="這邊輸入說明" 
              >
            </td>
          </tr>
          <tr class="ObjectItem">
            <td>banner設定</td>
            <td>
              <div>
                <img v-if="BannerIMGUrl" :src="BannerIMGUrl" width="150px">
                <div v-else class="error">尚未上傳圖片</div>
              </div>
              <div>
                <input
                  class="fileInput" 
                  type="file" 
                  id="fileBannerInput"
                  @change="handleBannerFileUpload"
                >
                <label 
                  class="ItemButton"
                  type="button"
                  for="fileBannerInput"
                >
                  選擇圖片
                </label>
                <div class="Font14">{{ BannerfileName || '尚未更換圖片' }}</div>
              </div>
            </td>
            
          </tr>
          <tr class="ObjectItem">
            <td>圖示設定</td>
            <td>
              <img v-if="IMGUrl" :src="IMGUrl" width="150px">
              <div v-else class="error">尚未上傳圖片</div>
            </td>
            <td>
              <input
              class="fileInput" 
              type="file" 
              id="fileIMGInput"
              @change="handleFileUpload">
              <label 
                class="ItemButton"
                type="button"
                for="fileIMGInput"
              >
                選擇圖片
              </label>
              <div class="Font14">{{ fileName || '尚未更換圖片' }}</div>
            </td>
          </tr>
        </tbody>
      </table>
    </form>
  </div>
</template>

<script>
import { inject, onMounted, ref } from 'vue';
import IsLoading from '../IsLoading.vue';
import WarnMessage from '../WarnMessage.vue';
import { computed } from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';
import { eventBus } from '@/eventBus';

export default {
  props:{
    number:String,
  },
  components:{
    WarnMessage,
    IsLoading,
  },
  setup(props){
    const store               = useStore();
    const router              = useRouter();
    const apiUrl              = inject('apiUrl');
    const isLoading           = ref(true);
    const localName           = ref('');
    const localExplain        = ref('');
    const localBanner         = ref('');
    const localIMG            = ref('');
    const selectedBannerImage = ref(null);
    const selectedImage       = ref(null);
    const BannerfileName      = ref('');
    const fileName            = ref('');

    const navbarTwoName = computed(()=> store.getters['WebsiteInformation/getNavbarTwoName']);
    const navbarOption = computed(() => store.getters['WebsiteInformation/getNavbarOption']);
    const navbarOptionInfo = computed(() => {
      return navbarOption.value.find(item => item.number === props.number);
    });

    onMounted(() => {
      const info = navbarOptionInfo.value;
      if (info) {
        localName.value = info.name;
        localExplain.value = info.explain;
        localBanner.value = info.banner;
        localIMG.value = info.img;
      }
      isLoading.value = false;
      window.scroll(0, 0);
    });

    //獲取圖片
    const BannerIMGUrl  = computed(() =>
      localBanner.value
      ?`${apiUrl}/src/assets/article/${localBanner.value}`
      :''
    );
    const IMGUrl  = computed(() =>
    localIMG.value
      ?`${apiUrl}/src/assets/home/${localIMG.value}`
      :''
    );

    //處理圖片上傳
    const handleBannerFileUpload = (event) => {
      selectedBannerImage.value = event.target.files[0];
      BannerfileName.value  = selectedBannerImage.value ? selectedBannerImage.value.name : '';
    }

    const handleFileUpload = (event) => {
      selectedImage.value = event.target.files[0];
      fileName.value  = selectedImage.value ? selectedImage.value.name : '';
    }

    const goBack = () =>{
      router.go(-1);
    }

    //處理送出
    const submitArticleOprionEdite = async() =>{      
      try{
        const response =  await store.dispatch('WebsiteInformation/ArticleOptionUpdate', {
          number: props.number,
          name: localName.value,
          explain: localExplain.value,
          bannerIMG: selectedBannerImage.value || '',
          homeIMG: selectedImage.value || ''
        });
        //接著獲取使否成功
        if(response.success){
          localStorage.setItem('successMessage', `${response.message}`);
          router.push('/BackStage/Article');
        } else {
          eventBus.emit('sentErrorMessage', `${response.message}`);
        }
      } catch (error) {
        eventBus.emit('sentErrorMessage', error?.message || '發生未知錯誤');
      }finally {
        window.scroll(0, 0);
      }      
    };

    return{
      isLoading,
      localName,
      localExplain,
      BannerIMGUrl,
      IMGUrl,
      handleBannerFileUpload,
      handleFileUpload,
      fileName,
      BannerfileName,
      goBack,
      submitArticleOprionEdite,
      navbarTwoName,
    }
  }
}
</script>

<style>
</style>