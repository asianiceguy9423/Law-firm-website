<template>
  <table class="RouterPage">
    <thead>
      <tr class="ObjectBox ObjectBoxFlex ObjectBoxBoerderBottom PaddingLeftRight">
        <th colspan="4" class="TitleH3">文章列表</th>
        <th colspan="1">
          <router-link 
            :to="{
              path: `/BackStage/Article/ArticleAdd`,
            }"
          >
            <button class="ItemButton" type="button">
              +新增文章
            </button>
          </router-link>
        </th>      
      </tr>
      <tr class="FormItem BackColorBlue">
        <th class="FormItemObjectNumber ObjectBoxNumber ObjectToMinWidthDisplayNone">
          編號      
        </th>
        <th class="FormItemObjectNumber ObjectBoxNumber">
          顯示        
        </th>
        <th class="FormItemObjectBox">
          文章標題      
        </th>
        <th class="FormItemObjectBox ObjectToMinWidthDisplayNone">
          圖片       
        </th>
        <th class="FormItemObjectBox">
          操作      
        </th>
      </tr>
    </thead>

    <tbody>
      <tr 
        class="FormItem ObjectBoxBoerderBottom FormItemToHover" 
        v-for="(Item, index) in ArticleInfo" 
        :key="Item.id"
      >
        <td class="FormItemObjectNumber ObjectBoxNumber ObjectToMinWidthDisplayNone">
          {{ index +1 }}
        </td>
        <td class="FormItemObjectNumber ObjectBoxNumber">
          <input 
            type="checkbox"
            :checked="Number(Item.display) === 1"
            @change="toggleDisplay(Item)"
          >
        </td>
        <td class="FormItemObjectBox TextAlignLeft">
          {{ Item.title }}
        </td>
        <td class="FormItemObjectBox ObjectToMinWidthDisplayNone">
            <img 
              v-if="Item.banner" 
              v-lazy="getImagUrl(Item.banner)" 
              width="150px"
            >
            <div v-else class="errorBold">沒有添加圖片</div>
        </td>
        <td class="FormItemObjectBox">
          <div class="ItemButtonTh">
            <router-link 
              class="ItemButton ItemButtonWidthMax hidden" 
              :to="`/BackStage/Article/ArticleEdite/${Item.id}`"
            >
              編輯
            </router-link>
            <button 
              @click="deleteArticle(Item)" 
              class="ItemButton ItemButtonWidthMax hidden" 
              type="button"
            >
              刪除
            </button>
          </div>
        </td>
      </tr>
    </tbody>    

    

  </table>
</template>

<script>
import { eventBus } from '@/eventBus';
import { computed, inject, onMounted } from 'vue';
import { useStore } from 'vuex';

export default {
  props:{
    navbarTwoName:{
      type: String,
      default: ""
    }
  },
  setup(props, {emit}) {
    const store   = useStore();
    const apiUrl  = inject('apiUrl');

    onMounted(async()=>{
      const result = await store.dispatch('ArticleStore/fetchDetails');
      if(!result.success){
        eventBus.emit('sentErrorMessage', '載入失敗' + result.message);
      } else{
        emit('load', true);
      }
    })
    const ArticleInfo = computed(() => store.getters['ArticleStore/getArticlesStore']);
    
    //獲取圖片
    const getImagUrl = (imageName) => {
      if (!imageName) return ''; // 如果圖片名稱為空，回傳空字串
      return `${apiUrl}/src/assets/article/${imageName}`;
    };

    //開選顯示
    const toggleDisplay = (item) => {
      store.dispatch("ArticleStore/updateArticlesDisplay", item.id);      
    };

    //刪除處理
    const deleteArticle = async (item) =>{
      if(confirm('確定要刪除這個文章嗎?')) {
        try{
          const response = await store.dispatch('ArticleStore/deletArticle', item)
          if(response && response.success){
            alert('刪除成功')
          } else {
            alert('刪除失敗，請稍後再試');
          }
        } catch (error) {
          alert('刪除時發生錯誤:', error);
          console.error('刪除時發生錯誤:', error);
        }
      }
    }

    return{
      getImagUrl,
      toggleDisplay,
      ArticleInfo,
      deleteArticle,
    }
  }
}
</script>

<style lang="scss" scoped>
.FormItemObjectBox{
  display: flex;
  padding: 16px 20px;
  width: 24%;
}
.FormItemObjectNumber{
  display: flex;
  padding: 16px 20px;
  width: 6%;
}
@media (max-width:1024px){
  .FormItemObjectBox{
    padding: 12px 16px;
    width: 24%;
  }
  .FormItemObjectNumber{
    padding: 12px 16px;
  }
}
@media (max-width:768px) {
  .FormItemObjectBox{
    width: 28%;
  }
  .FormItemObjectNumber{
    padding: 12px 16px;
    width: 10%;
  }
  .ObjectToMinWidthDisplayNone{
    display: none;
  }  
}
</style>