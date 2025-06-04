<template>
  <IsLoading  v-if="!isReady"/>
  <div v-else>
    <div 
      class="banner"
      :style="styleVaers"
    >
    </div>
    <div 
      class="ArticlePage" 
      :style="styleVaers"
    >
      <div class="ArticlePage_Link">
        <div>
          <router-link 
            class="ArticlePage_Link_Button"
            to="/Home"
          >
            首頁
          </router-link>
          <svg xmlns="http://www.w3.org/2000/svg"  height="14" width="8.75" viewBox="0 0 320 512">
            <path fill="currentColor" d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/>
          </svg>
          <button class="ArticlePage_Link_Button" type="button">
            {{ bannerTitle }}
          </button>
          
        </div>     
        <div class="ArticlePage_Link_ArticlesName">        
          <svg xmlns="http://www.w3.org/2000/svg"  height="14" width="8.75" viewBox="0 0 320 512">
            <path fill="currentColor" d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/>
          </svg>
          <button class="ArticlePage_Link_Button" type="button">
            {{ articlesDetails?.title }}
          </button>
        </div>
        
      </div>

      <div class="ArticlesPage_Content">
        <h1 class="ArticlesPage_Content_title">
          {{ articlesDetails?.title }}
        </h1>
        <div class="ArticlesPage_Content_Image" >
          <img 
            :src="getImageUrl(articlesDetails?.context_image)" 
            alt=""
          >        
        </div>
        <div 
          class="ArticlesPage_Content_Introduction" 
          v-if="cleanContext" 
          v-html="cleanContext"
        ></div>
      </div>
      <button class="ArticlePage_Button">開始免費諮詢</button>
      <div class="ArticlesPage_Content_Claim">
        <p>
          ※聲明：
        </p>
        <li>
          著作權由「Jimmy」及「Chatgpt」合作書寫。
        </li>
        <li>
          文章資料內容僅供參考，不宜直接引用為主張或訴訟用途，具體個案仍請洽詢專業律師。
        </li>
        <li>
          法令具時效性，文章內容及所引用資料，請自行查核法令動態及現行有效之實務見解。
        </li>
      </div>
    </div>
  </div>
</template>

<script>
import { computedStyleVars, getIMGUrl } from '@/utils/tools';
import { computed, inject, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import { useStore } from 'vuex';
import IsLoading from '../IsLoading.vue';

export default {
  components:{
    IsLoading,
  },
  setup() {
    const route   = useRoute();
    const store   = useStore();
    const apiUrl  = inject('apiUrl');
    const isReady = computed(()=>
      articlesDetails.value &&
      bannerTitle.value &&
      bannerIMG.value &&
      cleanContext.value
    );

    const currentNumber = computed(() => route.params.number);
    const currentID = computed(() => route.params.id);

    const fetchData = async() =>{
      await store.dispatch('ArticleStore/fetchDetails');
      await store.dispatch('WebsiteInformation/fetchDetails');
      window.scroll(0, 0);
    }
    onMounted(fetchData);

    watch([() => route.params.number, () => route.params.id], async() =>{
      await fetchData();
    })

    const BannerInfo = computed(() => store.getters['WebsiteInformation/getNavbarOption']);
    const ArticlesDetilasInfo = computed(() => store.getters['ArticleStore/getArticlesStore']);

    const bannerIMG =  computed(() =>{
      const matched = ArticlesDetilasInfo.value.find(option => option.class === currentNumber.value && option.id === currentID.value);
      return getIMGUrl(apiUrl, 'article', matched?.banner)
    });

    const getImageUrl = (imageNmae) =>{
      if (!imageNmae) return '';
      return getIMGUrl(apiUrl, 'article', imageNmae)
    }

    const bannerTitle = computed(() => {
      const matched = BannerInfo.value.find(option => option.number === currentNumber.value);
      return matched?.name || '';
    })

    const articlesDetails = computed(() => {
      return ArticlesDetilasInfo.value.find(option => option.class === currentNumber.value && option.id === currentID.value)
    })

    const cleanContext = computed(() => {
      if (!articlesDetails.value?.context) return '';
      return articlesDetails.value.context
        .replace(/\n/g, '')       // 去除換行符
        .replace(/\s{2,}/g, ' ')  // 多空格壓成一格
    });

    //獲取顏色
    const styleVaers = computedStyleVars(()=>bannerIMG.value);

    return {
      styleVaers,
      articlesDetails,
      getImageUrl,
      bannerTitle,
      cleanContext,
      isReady,
    }
  }
}
</script>

<style lang="scss" scoped>
.banner{
  position: relative;
  width: 100%;
  height: 200px;
  display: flex;
  justify-content: center;
  align-items: center;

  &::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background-image: var(--bg-url);
    background-size: cover;
    background-position: center;
    z-index: -2;
  }
  &::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background-color: black;
    opacity: 0.5; // 越高越深
    z-index: -1; // 蓋在圖片上，但在內容下
  }
}
.ArticlePage{
  width: 100%;
  height: auto;
  background-color: #fff;
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 40px 60px;
  box-sizing: border-box;

  .ArticlePage_Link{
    display: flex;
    width: 100%;
    border-bottom: 1px solid #333333;
    padding-bottom: 10px;
    align-items: center;

    .ArticlePage_Link_Button{
      border: none;
      border-radius: 40px;
      padding: 4px 10px;
      font-size: 16px;
      cursor: pointer;
      background-color: #fff;
      color: rgb(var(--fourth-color-rgb));
      transition: 0.3s;
    }
    .ArticlePage_Link_Button:hover{
      background-color: #eceff3;
    }
  }
  .ArticlesPage_Content{
    display: flex;   
    flex-direction: column;

    .ArticlesPage_Content_title{
      padding-top: 20px;
      padding-bottom: 28px;
    }

    .ArticlesPage_Content_Image{
      display: flex;
      flex-direction: column;
      align-items: center;

      img{
        width: 60%;
        aspect-ratio: 1 / 1;
        object-fit: cover;
        display: block;
      }
    }
    .ArticlesPage_Content_Introduction{
      width: 100%;
    }
  }
  .ArticlePage_Button{
    font-size: 25px;
    font-weight: bold;
    color: rgb(var(--secondary-color-rgb));
    border-radius: 50px;
    border-style: none;
    background: color-mix(in srgb, rgb(var(--main-color-rgb)) 75%, black 25%);
    padding: 15px 35px;
    margin: 20px 0;
    transition: 0.4s;
    cursor: pointer;
  }
  .ArticlePage_Button:hover{
    background: color-mix(in srgb, rgb(var(--main-color-rgb)) 95%, black 5%);
  }
  .ArticlesPage_Content_Claim{
    text-align: left;
    width: 100%;

    p,
    li{
      font-size: 15px;
      line-height: 20px;
    }
  }
}
@media(max-width:1024px){
  .ArticlePage{
    padding: 20px 40px;

    .ArticlesPage_Content{
      .ArticlesPage_Content_title{
        padding-top: 12px;
        padding-bottom: 20px;
        font-size: 24px;
      }
    }
  }
}
@media(max-width:768px){
  .banner{
    height: 100px;
  }
  .ArticlePage{
    padding: 12px;

    .ArticlePage_Link{
      .ArticlePage_Link_ArticlesName{
        display: none;
      }
    }
  }
}
</style>

<style lang="scss">
.ArticlesPage_Content_Introduction_Context{
  .Introduction_Context_h3Box{
    width: 100%;
    border-top: 3px solid rgb(174, 151, 88);
    border-bottom: 3px solid rgb(174, 151, 88);
    padding: 16px 0px;
    margin: 28px 0;

    h3{
      text-align: center;
      font-size: 20px;
      white-space: pre-line;
    }
  }
  h4{
    width: 100%;
    font-size: 20px;
    font-weight: bold;
    padding: 12px 0;
  }
  p,
  li{
    width: 100%;
    font-size: 18px;
    line-height: 30px;
    list-style-type: disc;
    line-height: 1.7;

    span{
      font-weight: bold;
    }
  }
}
@media (max-width:1250px) {
  .ArticlesPage_Content_Introduction_Context{
    .Introduction_Context_h3Box{
      h3{
        font-size: 18px;
      }
    }
    h4{
      font-size: 18px;
    }
    p,
    li{
      font-size: 16px;
    }
  }
}
@media (max-width:768px) {
  .ArticlesPage_Content_Introduction_Context{
    p,
    li{
      font-size: 16px;
    }
  }  
}
</style>