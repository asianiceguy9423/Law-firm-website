<template>
  <IsLoading  v-if="!isReady"/>
  <div v-else>
    <div 
      class="banner"
      :style="styleVars"
    >
      <h1>{{ bannerTitle }}</h1>
    </div>

    <div class="articlesPage">
      <div 
        class="allArticles"
        data-aos="fade-up"
        data-aos-duration="1500"
      >
        <router-link 
          class="articles"
          v-for="article in articlesDetails"
          :key="article.id"
          :to="`/Articles/${currentNumber}/ArticlesWrok/${article.id}`"
        >
          <div class="imageAndTitle">
            <img class="imageAndTitle_Image" :src="getImageUrl(article.context_image)" alt="">
            <h2>{{ article.title }}</h2>
          </div>
          <p>{{ article.introduction }}</p>
        </router-link>

        <div class="articles">
          <div class="imageAndTitle">
            <img class="imageAndTitle_Image" :src="ArticlesFuturerReleaseIMG" alt="">
            <h2>{{ ArticlesFuturerReleaseInfo.name }}</h2>
          </div>
          <p>{{ ArticlesFuturerReleaseInfo.ArticlesFutureReleaseContent }}</p>
        </div>
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
      bannerIMG.value &&
      ArticlesFuturerReleaseIMG.value &&
      bannerTitle.value &&
      articlesDetails.value
    );

    // 取得路由參數
    const currentNumber = computed(() => route.params.number);

    const fetchData = async () => {
      await store.dispatch('ArticleStore/fetchDetails');
      await store.dispatch('WebsiteInformation/fetchDetails');
      await store.dispatch('ArticlesFuturerReleaseStore/fetchDetails');
      window.scroll(0, 0);
    };

    onMounted(fetchData);

    // 🔁 監聽路由參數變化（如從 /Articles/one 變成 /Articles/two）
    watch(() => route.params.number, async (newVal, oldVal) => {
      if (newVal !== oldVal) {
        await fetchData();
      }
    });

    const BannerInfo = computed(() => store.getters['WebsiteInformation/getNavbarOption']);
    const ArticlesDetailsInfo = computed(() => store.getters['ArticleStore/getArticlesStore']);
    const ArticlesFuturerReleaseInfo = computed(() => store.getters['ArticlesFuturerReleaseStore/getArticlesFuturerReleaseStore'])


    //獲取圖片
    const bannerIMG =  computed(() =>{
      const matched = BannerInfo.value.find(option => option.number === currentNumber.value);
      return getIMGUrl(apiUrl, 'article', matched?.banner)
    });

    const ArticlesFuturerReleaseIMG =  computed(() =>
    getIMGUrl(apiUrl, 'article', ArticlesFuturerReleaseInfo.value?.ArticlesFutureReleaseIMG)
    );

    const getImageUrl = (imageName) =>{
      if (!imageName) return '';
      return getIMGUrl(apiUrl, 'article', imageName)
    }

    const bannerTitle = computed(() => {
      const matched = BannerInfo.value.find(option => option.number === currentNumber.value);
      return matched?.name || '';
    })

    const articlesDetails = computed(() => {
      return ArticlesDetailsInfo.value.filter(option => option.class === currentNumber.value && option.display == 1)
    })

    const styleVars = computedStyleVars(()=>bannerIMG.value);

    return{
      styleVars,
      bannerTitle,
      articlesDetails,
      getImageUrl,
      currentNumber,
      ArticlesFuturerReleaseInfo,
      ArticlesFuturerReleaseIMG,
      isReady,
    }
  }
}
</script>

<style lang="scss" scoped>
.banner{
  position: relative;
  width: 100%;
  height: 400px;
  padding-top: 100px;
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
  h1{
    font-size: 40px;
    color: rgb(var(--secondary-color-rgb));
    text-shadow: #333333 1px 0px 10px;
    z-index: 2;
  }
}
.articlesPage{
  box-sizing: border-box;
  padding: 100px 60px;
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
  height: auto;
  background-color: rgb(var(--secondary-color-rgb));

  .allArticles{
    width: 100%;
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    column-gap: 16px;
    row-gap: 40px;

    .articles{
      display: flex;
      flex-direction: column;
      width: 100%;
      height: 260px;
      box-shadow: rgb(209, 209, 209) 1px 1px 10px;
      cursor: pointer;

      .imageAndTitle{
        position: relative;
        height: 200px;
        width: 100%;
        display: flex;
        justify-content: center;
        overflow: hidden;

        .imageAndTitle_Image{
          width: 100%;
          height: 100%;
          object-fit: cover;
          transition: 0.3s;
        }
        h2{
          position: absolute;
          width: 90%;
          top: 80px;
          text-align: center;
          color: #fff;
          font-size: 24px;
          font-weight: bold;
          text-shadow: rgb(6, 6, 6) 1px 1px 20px;
          transition: 0.3s;
          display: inline;
        }

      }
      p{
        font-size: 1rem;
        color: #1a1a1a;
        padding: 8px 12px;
      }
    }
    .articles:hover .imageAndTitle_Image{
      opacity: 0.5;
    }
    .articles:hover h2{
      top:60px;
    }
  }  
}

@media (max-width: 1024px) {
  .banner{
    height: 300px !important;
  }
  .articlesPage{
    padding: 28px 20px !important;
  }
  .allArticles{
    grid-template-columns: 1fr 1fr !important;
  }
}
@media (max-width: 768px) {
  .banner{
    height: 250px !important;

    h1{
      font-size: 33px !important;
    }
  }
  .articlesPage{
    padding: 16px 12px !important;
    .allArticles{
      display: grid !important;
      grid-template-columns: 1fr !important;
      justify-content: center !important;
      align-items: center !important;
      row-gap: 40px !important;

      .articles{
        max-width: none !important;
        width: 100% !important;
        height: 320px !important;

        .imageAndTitle{
          height: 280px !important;
        }
        p{
          text-align: center !important;
        }
      }
    } 
  }
}
</style>