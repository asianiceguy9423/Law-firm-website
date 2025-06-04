<template>
  <div 
    class="footer" 
    :style="styleVars"
  >
    <FooterInformation
    :LOGOimage      = "currentLOGO"
    :storeInfo      = "websiteInfo.storeInfo"
    />
    <FooterNavbar
      v-if="websiteInfo.navbarOptions.length > 0"
      :navbarOptions  = "websiteInfo.navbarOptions"
    />
    <FooterRelatedLink
      :LinkInfo      = "websiteInfo.LinkInfo"
      :mainColor    = "websiteInfo.mainColor"
      :secondaryColor    = "websiteInfo.secondaryColor"
    />
  </div>  
</template>

<script>
import FooterInformation from './FooterInformation.vue';
import FooterRelatedLink from './FooterRelatedLink.vue';
import FooterNavbar from './FooterNavbar.vue';
import { useStore } from 'vuex';
import { computed, inject, onMounted } from 'vue';
import { computedStyleVars, getIMGUrl } from '@/utils/tools';
export default {
  components:{
    FooterInformation,
    FooterRelatedLink,
    FooterNavbar,
  },
  setup() {
    const store = useStore();
    const styleVars = computedStyleVars();

    const apiUrl = inject('apiUrl');

    onMounted(() => {
      // 使用完整命名空間調用 action
      store.dispatch('WebsiteInformation/fetchDetails');
    });

    // 從 Vuex 獲取數據
    const websiteInfo = computed(() => store.getters['WebsiteInformation/getWebsiteInformations']);

    //LOGO獲取
    const currentLOGO = computed(() =>
    getIMGUrl(apiUrl, 'basic', websiteInfo.value.currentLOGO)
    );

    return {
      websiteInfo,
      currentLOGO,
      styleVars,
    }
  }
}
</script>

<style lang="scss" scoped>
::v-deep li{
  cursor: pointer;
  transition: 0.4s;
  color:rgb(var(--secondary-color-rgb));
}
::v-deep li:hover{
  color: rgb(var(--main-color-rgb));
}
.footer{
  display: flex;
  width: 100%;
  height: auto;
  background-color: rgb(var(--third-color-rgb));
  color: rgb(var(--secondary-color-rgb));
  justify-content: space-between;
  box-sizing: border-box;
  padding: 60px 100px;
}
::v-deep .Footers{
  display: flex;
  flex-direction: column;

  h3{
    font-size: 20px;
    margin-bottom: 8px;
  }
  ul{
    display: flex;
    flex-direction: column;
    row-gap: 5px;

    li{
      font-size: 16px;
    }
  }
}
@media(max-width: 1024px){
  .footer{
    flex-direction: column;
    justify-content: center;
    text-align: center;
    padding: 50px 20px;
    row-gap: 20px;
  }
  ::v-deep .Footers{
    align-items: center;

    h3{
      font-size: 24px;
    }
  }
}
</style>