<template>
  <IsLoading v-if="!isReady"/>
  <div v-else :style="styleVars">
    <div 
      class="banner"
    >
      <h1 class="bannerTitle">{{ ContactInfo.BannerTitle }}</h1>
    </div>
    <div class="ConnectionInfo">
      <h1 
        class="ConnectionInfoTitle" 
        data-aos="fade-zoom-in" 
        data-aos-duration="2000"
      >
        {{ ContactInfo.Title }}
      </h1>
      <div 
        class="ConnectionAll" 
        data-aos="fade-up"
        data-aos-duration="2000"
      >
        <div 
          class="Connection"
          v-for="(Info) in ContactInfoDetails" 
          :key="Info.id"
        >
          <h2>{{ Info.project  }}</h2>
          <span>{{ Info.explain_project }}</span>
        </div>
      </div>
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
    IsLoading,
  },
  setup() {
    const store     = useStore();
    const apiUrl    = inject('apiUrl');
    const isReady = computed(()=>{
    const contact = ContactInfo.value;
    return(
      contact && 
      contact.BannerIMG &&  
      contact.Title &&
      ContactInfoDetails
    )
    })

    onMounted(async()=>{
      await store.dispatch('ContactStore/fetchContactBanner');
      await store.dispatch('ContactStore/fetchContactStoreInfo');
      window.scroll(0, 0);
    })

    const ContactInfo = computed(() => store.getters['ContactStore/getContactStore'])

    //獲取圖片
    const bannerIMG =  computed(() =>
    getIMGUrl(apiUrl, 'contact', ContactInfo.value?.BannerIMG)
    );

    //獲取顏色
    const styleVars = computedStyleVars(()=>bannerIMG.value);

    //計算display
    const ContactInfoDetails = computed(() =>
    ContactInfo.value.InfoDetails.filter((info) => info.display == 1)
    );
    console.log(styleVars.value)

    return{
      styleVars,
      ContactInfo,
      ContactInfoDetails,
      isReady,
    }
  }
}
</script>

<style lang="scss" scoped>
h1{
  text-align: center;
}
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
    background-attachment: fixed;
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
    opacity: 0.3; // 越高越深
    z-index: -1; // 蓋在圖片上，但在內容下
  }
  .bannerTitle{
  font-size: 40px;
  color: #fff;
  text-shadow: #333333 1px 0px 10px;
  z-index: 2;
  }
}
.ConnectionInfo{
  width: 100%;
  height: auto;
  background-color: #fff;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 80px 12px;
  box-sizing: border-box;

  .ConnectionInfoTitle{
    margin-bottom: 40px;
  }
  .ConnectionAll{
    display: flex;
    flex-direction: column;
    flex-wrap: wrap;
    row-gap: 16px;

    .Connection{
      display: flex;
      flex-wrap: wrap;
      align-items: center;

      h2{
        font-size: 20px;
        font-weight: bold;
        font-weight: 700;
        color: color-mix(in srgb, rgb(var(--main-color-rgb)) 75%, black 25%);
        width: 88px;
        margin-right: 16px;
      }
      span{
        color: black;
        
        font-weight: lighter;
        font-size: 20px;
      }
    }
  }
}
@media(max-width:1024px){
  .banner{
    height: 300px;
  }
  .ConnectionInfo{
    .ConnectionInfoTitle{
      margin-bottom: 28px;
    }
    .ConnectionAll{
      .Connection{
        h2{
          font-size: 18px;
        }
        span{
          font-size: 18px;
        }
      }
    }
  }
}
@media(max-width:768px){
  .banner{
    height: 250px;

    .bannerTitle{
      font-size: 33px;
    }
  }  
}
@supports (-webkit-overflow-scrolling: touch) {
  .banner::before {
    background-attachment: scroll;
  }
}
</style>