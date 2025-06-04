<template>
  <div class="BK">
    <WarnMessage/>
    <IsLoading v-show="isLoading"/>

    <div v-show="!isLoading" class="FlexBoxBottom PaddingLeftRight">
      <div>
        <div class="LinkButtonMarginLeft">
          <button @click="goBack" class="PointButton PointMargin" type="button">{{ navbarName }}</button>
          <svg xmlns="http://www.w3.org/2000/svg"  height="14" width="8.75" viewBox="0 0 320 512">
            <path fill="#acafc4" d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/>
          </svg>
          <button class="PointButton" type="button">新增文章</button>
        </div>
        <h1>新增文章</h1>
      </div>
      <div>
        <button @click="goBack" type="button" class="ItemButton ItemButtonWhite">取消</button>
        <button @click="submitArticlesAdd" type="submit" class="ItemButton">確定新增</button>
      </div>
    </div>

    <form v-show="!isLoading" @submit.prevent="submitArticlesAdd" enctype="multipart/form-data" class="PaddingLeftRight">
      <table class="RouterPage">
        <thead>
          <tr class="ObjectBox ObjectBoxBoerderBottom">
            <th class="TitleH3">輸入文章</th>
          </tr>
        </thead>  

        <tbody class="ObjectBox ObjectGrid">
          <tr class="ObjectItem">
            <td>標題</td>
            <td>
              <input 
                class="InputText"
                type="text" 
                v-model="ArticleTitle" 
                placeholder="輸入文章標題" 
              >
            </td>
          </tr>

          <tr class="ObjectItem">
            <td>分類</td>
            <td class="buttondIV">
              <button 
                type="button"
                class="ItemButton Lawbutton" 
                :class="{'ActiveLawBtn' : option.number === activeOptionNumber }"
                @click="setActive(option.number)"
                v-for="(option) in navbarOption" 
                :key="option.id"
              >
                {{ option.name }}
              </button>            
            </td>
          </tr>

          <tr class="ObjectItem">
            <td>選擇Banner</td>
            <td>
              <input
              class="fileInput" 
              type="file" 
              id="BannerAddInput"
              @change="handleBannerFileUpload">
              <label 
                class="ItemButton"
                type="button"
                for="BannerAddInput"
              >
                選擇圖片
              </label>
              <div class="Font14">{{ BannerfileName || '尚未更換圖片' }}</div>
            </td>
          </tr>

          <tr class="ObjectItem">
            <td>選擇內文圖片</td>
            <td>
              <input
                class="fileInput" 
                type="file" 
                id="ArticleIMGAddInput"
                @change="handleArticleIMGFileUpload"
              >
              <label 
                class="ItemButton"
                type="button"
                for="ArticleIMGAddInput"
              >
                選擇圖片
              </label>
              <div class="Font14">
                {{ ArticleIMGfileName || '尚未更換圖片' }}
              </div>
            </td>
          </tr>

          <tr class="ObjectItem">
            <td>介紹</td>
            <td>
              <textarea 
                class="InputText"
                type="text" 
                v-model="ArticleIntroduction" 
                placeholder="輸入介紹" 
              ></textarea>
            </td>
          </tr>

          <tr class="ObjectItem">
            <td>內文(以html形式)</td>
            <td>
              <textarea 
                class="InputText"
                v-model="ArticleContext" 
                placeholder="輸入內文" 
              ></textarea>
            </td>            
          </tr>
        </tbody>
      </table>
    </form>
  </div>  
</template>

<script>
import { computed, inject, onMounted, ref } from 'vue';
import WarnMessage from '../WarnMessage.vue';
import IsLoading from '../IsLoading.vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';
import axios from 'axios';
import { eventBus } from '@/eventBus';

export default {
  components:{
    WarnMessage,
    IsLoading,
  },
  setup(){
    const isLoading           = ref(true);
    const router              = useRouter();
    const store               = useStore();
    const apiUrl              = inject('apiUrl');
    const ArticleTitle        = ref('');
    const ArticleIntroduction = ref('');
    const ArticleContext      = ref(`
      <!-- 請按照基本格式做修改 -->
         <!--第一段-->
        <!-- 這是上下有兩條線的大標 -->
        <div class="h3Div">
          <h3>這裡是標題
          </h3>
        </div>
      <!-- 這裡是內文 -->
        <h4>這裡是標題</h4>
        <p>
          這裡是文字
        </p>
        <h4>這裡是標題</h4>
        <li>
          <span>
            標籤:
          </span>
            標籤內文
        </li>
        <br>
        <p>
          文字部分
        </p>
        <!--有需要加上第二 三段-->        
        <br>
        <p>
          總結文字
        </p>
        <br>
        <p>
          <span>
            以上是智慧財產權的基本認知，如果您對某個特定電影台詞是否受到保護，或有相關疑問，歡迎跟我們諮詢!
          </span>
        </p>
      `);

    onMounted(async() =>{
      const result = await store.dispatch('HomeStore/fetchDetails');
      if(!result.success){
        eventBus.emit('sentErrorMessage', '載入失敗' + result.message);
      }
      isLoading.value = false;
      window.scroll(0, 0);
    })

    const navbarOption = computed(() => store.getters['WebsiteInformation/getNavbarOption']);
    const navbarName = computed(()=> store.getters['WebsiteInformation/getNavbarTwoName']);

    //處理圖片
    const selectedBanner        = ref(null);
    const selectedArticleIMG    = ref(null);
    const BannerfileName        = ref('');
    const ArticleIMGfileName    = ref('');

    const handleBannerFileUpload = (event) => {
      selectedBanner.value = event.target.files[0];
      BannerfileName.value  = selectedBanner.value ? selectedBanner.value.name : '';
    }
    const handleArticleIMGFileUpload = (event) => {
      selectedArticleIMG.value = event.target.files[0];
      ArticleIMGfileName.value  = selectedArticleIMG.value ? selectedArticleIMG.value.name : '';
    }

    //處理按鈕
    const activeOptionNumber  = ref(null);
    const setActive = (number) =>{
      activeOptionNumber.value = number;
    }

    const goBack = () =>{
      router.go(-1);
    }

    const warningCheck = () =>{
      if(!ArticleTitle.value.trim()) {
        eventBus.emit('sentErrorMessage', '標題不能為空');
        return;
      } else if(activeOptionNumber.value === null) {
        eventBus.emit('sentErrorMessage', '分類不能為空');
        return;
      } else if(selectedBanner.value === null) {
        eventBus.emit('sentErrorMessage', 'banner不能為空');
        return;
      } else if(selectedArticleIMG.value === null) {
        eventBus.emit('sentErrorMessage', '內文圖片不能為空');
        return;
      } else if(!ArticleIntroduction.value.trim()) {
        eventBus.emit('sentErrorMessage', '介紹不能為空');
        return;
      } else if(!ArticleContext.value.trim()) {
        eventBus.emit('sentErrorMessage', '內文不能為空');
        return;
      }
      return true;
    }

    const buildFormData = () =>{
      const formData = new FormData();
      formData.append('title', ArticleTitle.value);
      formData.append('class', activeOptionNumber.value);      
      formData.append('introduction', ArticleIntroduction.value);
      formData.append('context', ArticleContext.value);
      if(selectedBanner.value) formData.append('banner', selectedBanner.value);
      if(selectedArticleIMG.value) formData.append('context_image', selectedArticleIMG.value);
      return formData;
    }

    const submitArticlesAdd = async()=>{
      if (!warningCheck()) return;
      const formData = buildFormData();     

      try{
        const response = await axios.post(`${apiUrl}/api/Add&Update/ArticlesAdd.php`, formData);
        const data = response.data;

        if(data.success) {
          store.commit('ArticleStore/CLEAR_ARTICELS');
          await store.dispatch('ArticleStore/fetchDetails');
          localStorage.setItem('successMessage', `${data.message}`);
          router.push('/BackStage/Article');          
        } else {
          eventBus.emit('sentErrorMessage', `${data.message}`);
        }
      } catch (error) {
        eventBus.emit('sentErrorMessage', `${error}`);
      }
    }

    return{
      isLoading,
      goBack,
      ArticleTitle,
      navbarOption,
      handleBannerFileUpload,
      handleArticleIMGFileUpload,
      BannerfileName,
      ArticleIMGfileName,
      ArticleIntroduction,
      ArticleContext,
      activeOptionNumber ,
      setActive,
      submitArticlesAdd,
      navbarName,
    }    
  }
}
</script>

<style lang="scss" scoped>
.buttondIV{
  display: flex;
  column-gap: 4px;
}

</style>