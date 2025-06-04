<template>
  <IsLoading v-if="!isReady"/>
  <div 
    v-else
    class="joinPage"
    :style="styleVaers"
  >
    <div 
      class="joinPage_content" 
      data-aos="fade-zoom-in" 
      data-aos-duration="2000"
    >
      <h1>{{ JoinInfo.JoinTitle }}</h1>
      <p>{{ JoinInfo.JoinContent }}</p>
      <button @click="redirectToUrl">{{ JoinInfo.JoinBtn }}</button>
    </div>
  </div>
</template>

<script>
import { computedStyleVars, getIMGUrl } from '@/utils/tools';
import { computed, inject, onMounted } from 'vue';
import { useStore } from 'vuex';
import IsLoading from '../IsLoading.vue';

export default {
  components:{
    IsLoading
  },
  setup() {
    const store = useStore();
    const apiUrl = inject('apiUrl');
    const isReady = computed(()=>{
      const join = JoinInfo.value;
      const web = WebInfo.value;
      return(
        join &&
        join.JoinTitle &&
        join.JoinContent &&
        join.JoinBtn &&
        join.JoinIMG &&
        web
      );
    });

    onMounted(async() =>{
      await store.dispatch('JoinStore/fetchDetails');
      await store.dispatch('WebsiteInformation/fetchDetails');
      window.scroll(0, 0);
    })
    const JoinInfo = computed(() => store.getters['JoinStore/getJoinStore']);
    const WebInfo = computed(()=> store.getters['WebsiteInformation/getStoreLinkInfo']);

    //獲取圖片
    const backgroundIMG =  computed(() =>
      getIMGUrl(apiUrl, 'join', JoinInfo.value?.JoinIMG)
    );

    //獲取顏色
    const styleVaers = computedStyleVars(()=>backgroundIMG.value)

    const linkUrl = () =>{
      const lineInfo = WebInfo.value.find( item => item.name === 'line');
      return lineInfo?.link || '';
    } 

    const redirectToUrl = () =>{
      window.open(`${linkUrl()}`,"_blank");
    }
    
    return{
      JoinInfo,
      redirectToUrl,
      styleVaers,
      isReady,
    }
  }
}
</script>

<style lang="scss" scoped>
.joinPage{
  position: relative;
  display: flex;
  width: 100%;
  height: 100vh;
  padding: 0 60px;
  box-sizing: border-box;
  color: rgb(var(--secondary-color-rgb));
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

  .joinPage_content{
    position: relative;
    display: flex;
    width: 100%;
    flex-direction: column;
    align-items: center;
    text-align: center;
    z-index: 1;
    padding-top: 100px;

    h1{
      font-size: 100px;
      text-shadow: #333333 1px 0px 10px;
      padding-bottom: 16px;
    }
    p{
      border-top: 1px solid rgb(var(--secondary-color-rgb));
      padding-top: 10px;
      white-space: pre-line
    }
    button{
      font-size: 25px;
      font-weight: bold;
      color: rgb(var(--secondary-color-rgb));
      border-radius: 50px;
      border-style: none;
      background: color-mix(in srgb, rgb(var(--main-color-rgb)) 82%, black 18%);
      padding: 15px 35px;
      margin-top: 35px;
      transition: 0.4s;
      cursor: pointer;
    }
    button:hover{
      background: rgb(var(--main-color-rgb));
    }
  }
}
@media(max-width:1024px){
  .joinPage{
    padding: 0 40px;

    .joinPage_content{
      h1{
        padding-bottom: 8px;
      }
      p{
        padding-top: 6px;
      }
    }
  }
}
@media(max-width:760px){
  .joinPage{
    padding: 0 16px;
  }
}

@supports (-webkit-overflow-scrolling: touch) {
  .joinPage::before {
    background-attachment: scroll;
  }
}
</style>