<template>  
  <div 
    class="aboutThree" 
    :style="styleVars"
  >
    <h1 
      class="aboutThree_title" 
      data-aos="fade-zoom-in" 
      data-aos-duration="2000"
    >
      專業團隊
    </h1>
    <div class="aboutThree_InfoBox">
      <div 
        class="aboutThree_InfoBox_information" 
        data-aos="fade-up"
        data-aos-duration="1500"
        v-for="(member) in memberInfoFilter" 
        :key="member.id"
      >
      <div class="aboutThree_InfoBox_information_imageBox">
        <img class="aboutThree_InfoBox_information_imageBox_personImage" :src="getIMGUrl(apiUrl, 'about',member.image_name)" loading="lazy">
      </div>
        
        <div class="infoContent">
          <h2 class="longH2">
            {{ member.person_name }} {{ member.position }}
          </h2>
          <h2 class="shortH2">
            {{ member.person_name }} 
            <br>  
            <span class="position">
              {{ member.position }}
            </span>
          </h2>
          <div class="infoContentBox">
            <div>
              <h3>專長</h3>
              <p>{{ member.skill }}</p>
            </div>
            <div>
              <h3>經歷</h3>
              <p>{{ member.introduction }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    
  </div>
</template>

<script>
import { computedStyleVars, getIMGUrl } from '@/utils/tools';
import { computed, inject, onMounted } from 'vue';
import { useStore } from 'vuex';

export default {
  props:{
  BK: {
    type: String,
    default: '',
  },
  },
  setup(props) {
    const store = useStore();
    const apiUrl = inject('apiUrl');
    const styleVars = computedStyleVars(()=>props.BK);
    
    onMounted( () => {
       store.dispatch('AboutMemberStore/fetchDetails')
    })

    const memberInfo = computed(() => store.getters['AboutMemberStore/getAboutMemberStore'])

    const memberInfoFilter = computed(()=>
      memberInfo.value.filter((info) => info.display == 1)
    )

    //獲取圖片
    const backgroundUrl = computed(() => 
      getIMGUrl(apiUrl, 'about', props.BK)
    );

    return {
      memberInfoFilter,
      apiUrl,
      getIMGUrl,
      backgroundUrl,
      styleVars,
    }
  }
}
</script>

<style lang="scss" scoped>
.aboutThree{
  position: relative;
  display: flex;
  width: 100%;
  height: auto;
  min-height: 300px;
  flex-direction: column;
  align-items: center;
  padding: 40px 24px;
  box-sizing: border-box;
  overflow: hidden;

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
    opacity: 0.7; // 越高越深
    z-index: -1; // 蓋在圖片上，但在內容下
  }
  .aboutThree_title{
    font-weight: 400;
    color: rgb(var(--secondary-color-rgb));
    margin-bottom: 40px;
  }
  .aboutThree_InfoBox{
    display: flex;
    flex-direction: column;
    row-gap: 28px;
    width: 100%;
    align-items: center;

    .aboutThree_InfoBox_information{
      display: flex;
      height: auto;
      width: 100%;
      max-width: 80%;
      column-gap: 28px;
      background-color: rgb(var(--secondary-color-rgb));
      align-items: center;
      padding: 80px 28px;
      box-sizing: border-box;

      .aboutThree_InfoBox_information_imageBox{
        display: flex;
        width: 210px;
        height: 210px;

        .aboutThree_InfoBox_information_imageBox_personImage{
          width: 210px;
          height: auto;
          object-fit: cover;
          object-position: top;
        }
      }

      .infoContent{
        display: flex;
        flex-direction: column;
        row-gap: 12px;
        max-width: 800px;

        .longH2{
          font-weight: 400 ;
          font-size: 28px ;
          padding-bottom: 4px;
        }
        .shortH2{
          display: none;
        }
        .infoContentBox{
          display: flex;
          flex-direction: column;
          row-gap: 8px;

          div{
            h3{
              font-size: 24px;
              font-weight: normal;
              color: color-mix(in srgb, rgb(var(--main-color-rgb)) 85%, black 15%);
            }
          }
        }
      }
    }
  } 
}
@supports (-webkit-overflow-scrolling: touch) {
  .aboutThree::before {
    background-attachment: scroll;
  }
}
@media(max-width: 1024px){
  .aboutThree{
    .aboutThree_InfoBox{
      width: 100%;
      .aboutThree_InfoBox_information{
        min-height: auto ;
        max-width: 100% ;
        padding: 60px 16px ;
      }
    }
  }
  h3{
    font-size: 22px !important;
  }
}
@media(max-width: 768px){
  .aboutThree{
    padding: 40px 16px;
    
    .aboutThree_title{
      margin-bottom: 28px;
    }

    .aboutThree_InfoBox{
      .aboutThree_InfoBox_information{
        flex-direction: column;
        text-align: center;
        height: auto;
        padding: 40px 16px !important;

        .infoContent{
          .longH2{
            display: none;
          }
          .shortH2{
            display: inline-block;
          }
          h2{
            font-weight: 400;
            padding: 10px 0;
          }
          .position {
            font-size: 24px;
          }
        }
      }
    }
  }  
}
</style>