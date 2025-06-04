<template>
  <div class="BK">
    <WarnMessage/>
    <IsLoading v-show="isLoading"/>

    <div v-show="!isLoading" class="ObjectBoxFlex PaddingLeftRight">
      <h1>{{ navbarTwoName }}</h1>
      <button @click="submitArticles" type="submit" class="ItemButton">確定更新</button> 
    </div>

    <div v-show="!isLoading" class="PaddingLeftRight PaddingBottom">
      <form  @submit.prevent="submitArticles" enctype="multipart/form-data" class="formGrid">
        <ArticleOption
          v-model:navbarOption = "navbarOption"
        />

        <ArticleAllArticles
          @load="handleChildLoad"
          :navbarTwoName ="navbarTwoName"
        />

        <AticlesFutureRelease
        v-model:name      = "ArticlesFuturerReleaseInfo.ArticlesFutureReleaseName"
        v-model:content    = "ArticlesFuturerReleaseInfo.ArticlesFutureReleaseContent"
        v-model:display   = "ArticlesFuturerReleaseInfo.ArticlesFutureReleaseDisplay"
        v-model:image     = "ArticlesFutureReleaseIMG"
        v-model:fileName  = "ArticlesFutureReleaseIMGFileName"
        />
      </form>
    </div>
  </div>
</template>

<script>
import { computed, inject, onMounted, ref, watch } from 'vue';
import IsLoading from '../IsLoading.vue';
import WarnMessage from '../WarnMessage.vue';
import { useStore } from 'vuex';
import ArticleOption from './ArticleOption.vue';
import ArticleAllArticles from './ArticleAllArticles.vue';
import AticlesFutureRelease from './AticlesFutureRelease.vue';
import { eventBus } from '@/eventBus';

export default {
  components:{
    WarnMessage,
    IsLoading,
    ArticleOption,
    ArticleAllArticles,
    AticlesFutureRelease,
  },
  setup() {
    const isLoading     = ref(true);
    const store         = useStore();
    const apiUrl        = inject('apiUrl');
    const parentLoaded  = ref(false);
    const childLoaded   = ref(false);

    onMounted(async() =>{
      const resultWebsiteInformation = await store.dispatch('WebsiteInformation/fetchDetails');
      if(!resultWebsiteInformation.success){
        eventBus.emit('sentErrorMessage', '載入失敗' + resultWebsiteInformation.message);
      }
      const resultArticlesFuturerReleaseStore = await store.dispatch('ArticlesFuturerReleaseStore/fetchDetails')
      if(!resultArticlesFuturerReleaseStore){
        eventBus.emit('sentErrorMessage', '載入失敗' + resultArticlesFuturerReleaseStore.message);
      }
      parentLoaded.value = true;    
      window.scroll(0, 0);
    })

    // 子組件通知讀取完成時
    const handleChildLoad = (isLoad) => {
      if (isLoad) {
        childLoaded.value = true;
      }
    };

    // 當兩個都為 true，才取消 loading
    watch([parentLoaded, childLoaded], ([p, c]) => {
      if (p && c) {
        isLoading.value = false;
      }
    });

    const navbarTwoName = computed(()=> store.getters['WebsiteInformation/getNavbarTwoName']);
    const navbarOption = computed(() => store.getters['WebsiteInformation/getNavbarOption'])
    const ArticlesFuturerReleaseInfo = computed(() => store.getters['ArticlesFuturerReleaseStore/getArticlesFuturerReleaseStore'])

    //獲取圖片
    const ArticlesFutureReleaseIMG = computed(() =>
      ArticlesFuturerReleaseInfo.value.ArticlesFutureReleaseIMG
      ?`${apiUrl}/src/assets/article/${ArticlesFuturerReleaseInfo.value.ArticlesFutureReleaseIMG}`
      :''
    );

    const ArticlesFutureReleaseIMGFileName = ref(null);

    const buildFormData = () =>{
      const formData = new FormData();
      formData.append('ArticlesName' ,ArticlesFuturerReleaseInfo.value.ArticlesFutureReleaseName);
      formData.append('ArticlesContent' ,ArticlesFuturerReleaseInfo.value.ArticlesFutureReleaseContent);
      formData.append('ArticlesDisplay' ,ArticlesFuturerReleaseInfo.value.ArticlesFutureReleaseDisplay);
      if(ArticlesFutureReleaseIMGFileName.value) formData.append('ArticlesIMG' ,ArticlesFutureReleaseIMGFileName.value);
      return formData;
    }

    const submitArticles = async () => {
      isLoading.value = true;
      try{
        const formData = buildFormData();
        const response = await store.dispatch('ArticlesFuturerReleaseStore/updateArticlesPage', formData);

        if(!response || !response.success) {
          eventBus.emit('sentErrorMessage', response?.message || '未知錯誤')
        } else {
          eventBus.emit('sentSuccessMessage',response.message)
          ArticlesFutureReleaseIMGFileName.value = null;
        }
      } catch (error) {
        eventBus.emit('sentErrorMessage', '請求失敗:' + error.message);
      } finally {
        isLoading.value = false;
      }
    }

    return{
      isLoading,
      navbarTwoName,
      navbarOption,
      handleChildLoad,
      ArticlesFuturerReleaseInfo,
      ArticlesFutureReleaseIMG,
      ArticlesFutureReleaseIMGFileName,
      submitArticles,
    }
  }
}
</script>

<style>
</style>