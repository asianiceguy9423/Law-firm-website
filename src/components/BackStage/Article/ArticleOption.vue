<template>
  <table class="RouterPage">
    <thead>
      <tr class="ObjectBox ObjectBoxFlex ObjectBoxBoerderBottom PaddingLeftRight">
        <th colspan="5" class="TitleH3">編輯分類</th>
      </tr>
      <tr class="FormItem BackColorBlue">
        <th class="FormItemObjectNumber ObjectBoxNumber ObjectToMinWidthDisplayNone">
          編號      
        </th>
        <th class="FormItemObjectNumber ObjectBoxNumber">
          顯示      
        </th>
        <th class="FormItemObjectBox">
          名稱       
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
        v-for="(option, index) in navbarOption" 
        :key="option.id"
      >
        <td class="FormItemObjectNumber ObjectBoxNumber ObjectToMinWidthDisplayNone">
          {{ index +1 }}
        </td>
        <td class="FormItemObjectNumber ObjectBoxNumber">
          <input 
            type="checkbox"
            :checked="(option.display)"
            @change="toggleDisplay(index, $event.target.checked)"
          >
        </td>
        <td class="FormItemObjectBox TextAlignLeft">
          {{ option.name }}
        </td>
        <td class="FormItemObjectBox ObjectToMinWidthDisplayNone">
          <img v-if="option.banner" v-lazy="getImagUrl(option.banner)" width="150px">
          <div v-else class="errorBold">沒有添加圖片</div>
        </td>
        <td class="FormItemObjectBox">
          <div class="ItemButtonTh">
            <router-link 
              class="ItemButton ItemButtonWidthMax hidden" 
              :to="`/BackStage/Article/ArticleOptionEdit/${option.number}`"
            >
              編輯
            </router-link>
          </div>
        </td>
      </tr>
    </tbody>    
  </table>
</template>

<script>
import { inject } from 'vue';
import { useStore } from 'vuex';

export default {
  props:{
    navbarOption:{
      type: Array,
      default: ()=>([])
    },
    navbarTwoName:{
      type: String,
      default: ""
    }
  },
  setup(props) {
    const store   = useStore();
     const apiUrl = inject('apiUrl');
    
    //獲取圖片
    const getImagUrl = (imageName) => {
      if (!imageName) return ''; // 如果圖片名稱為空，回傳空字串
      return `${apiUrl}/src/assets/article/${imageName}`;
    };

    //開選顯示
    const toggleDisplay = (index, newDisplay) => {
      const displayItem = props.navbarOption[index];
      store.dispatch("WebsiteInformation/updateArticleOptionDisplay", {
        number: displayItem.number, // ✅ 傳遞 number 代替 id
        newDisplay
      });
    };

    return{
      getImagUrl,
      toggleDisplay,
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