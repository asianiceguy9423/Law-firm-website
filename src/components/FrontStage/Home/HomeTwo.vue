<template>
  <div 
    class="HomeTwo"
    :style="styleVars"
  >
    <h1
      class="HomeTwo_Title"
      data-aos="fade-zoom-in"
    >
      {{ title }}
    </h1>
    <div 
      class="HomeTwo_Options" 
      data-aos="fade-up"
    >
      <div 
        class="HomeTwo_Options_Details" 
        v-for="( option, index ) in filterNavbarOptions" 
        :key="index"
      >
        <router-link :to="`Articles/${option.number}`">
          <img 
            class="HomeTwo_Options_Details_a_img" 
            :src="getImagUrl(option.img)" alt=""
          >
          <h1 class="HomeTwo_Options_Details_a_h1">{{ option.name }}</h1>
          <p class="HomeTwo_Options_Details_a_p">{{ option.explain }}</p>
        </router-link>
      </div>      
    </div>
  </div>
</template>

<script>
import { computed, inject } from 'vue';
import { computedStyleVars } from '@/utils/tools';

export default {
  props:{
    navbarOptions :{
      type:     Array,
      default:  () => []
    },
    title :{
      type:     String,
      default:  '這裡是title2'
    },
  },

  setup(props){
     const apiUrl = inject('apiUrl');

    //處理option顯示
    const filterNavbarOptions = computed(()=>
      props.navbarOptions.filter((option) => option.display)
    );

    //獲取圖片url
    const getImagUrl = (img) =>{
      return img ? 
      `${apiUrl}/src/assets/home/${img}` 
      : new URL('@/assets/home/HomeTwoPic預設.png', import.meta.url).href;
    };

    const styleVars = computedStyleVars();

    return {
      filterNavbarOptions,
      getImagUrl,
      styleVars,
    }
  }
}
</script>

<style lang="scss" scoped>
.HomeTwo{
  display: flex;
  flex-direction: column;
  align-items: center;
  height: auto;
  width: 100%;
  background-color: rgb(var(--fourth-color-rgb));
  padding: 100px 12px;
  box-sizing: border-box;

  .HomeTwo_Title{
    font-weight: 400;
    color: rgb(var(--secondary-color-rgb));
    margin-bottom: 50px;
  }
  .HomeTwo_Options{
    display: flex;
    flex-wrap: wrap;
    row-gap: 24px;
    flex-direction: row;
    column-gap: 24px;
    width: 100%;
    justify-content: center;
    box-sizing: border-box;

    .HomeTwo_Options_Details{
      display: flex;
      padding: 24px 36px;
      width: 11%;
      background-color: rgba(var(--secondary-color-rgb), 0.15);
      border-radius: 2px;
      cursor: pointer;
      transition:  1s;

      a{
        display: flex;
        height: 240px;
        width: 100%;
        flex-direction: column;
        align-items: center;
        justify-content: center;      
        
        .HomeTwo_Options_Details_a_img{
          height: 90px;
          width: auto;
          object-fit: cover;  
        }
        .HomeTwo_Options_Details_a_h1{
          font-size: 24px;
          font-weight: normal;
          max-width: 120px;
          text-align: center;
          word-wrap: break-word;  /* 遇到長單詞也換行 */
          overflow-wrap: break-word; /* 確保強制換行 */
          white-space: normal; /* 允許正常換行 */
          color: rgb(var(--main-color-rgb));
          margin: 0;
          padding-top: 20px;
          padding-bottom: 8px;
        }
        .HomeTwo_Options_Details_a_p{
          font-size: 18px;
          max-width: 120px;
          text-align: center;
          word-wrap: break-word;  /* 遇到長單詞也換行 */
          overflow-wrap: break-word; /* 確保強制換行 */
          white-space: normal; /* 允許正常換行 */
          color: rgb(var(--secondary-color-rgb));
        }
      }
    }
    .HomeTwo_Options_Details:hover{
      background: linear-gradient(0deg, rgba(var(--main-color-rgb), 0.6) 0%, rgba(var(--main-color-rgb), 0.3) 23%, rgba(var(--fourth-color-rgb), 1) 100%);
      margin-top: -15px;

      .HomeTwo_Options_Details_a_img{
        display: none;
      }
    }    
  }
}
@media (max-width: 1024px) {
  .HomeTwo{
    padding: 50px 12px;

    .HomeTwo_Title{
      margin-bottom: 40px;
      font-size: 28px;
    }
    .HomeTwo_Options{
      .HomeTwo_Options_Details {
        width: 30% ; /* 讓 .options 在小螢幕時變成兩列 */
        padding: 10px 20px ; /* 減少內邊距，避免內容擠壓 */

        a{
          .HomeTwo_Options_Details_a_h1{
            font-size: 20px;
          }
        }
      }
    }  
  }
}
@media (max-width: 768px) {
  .HomeTwo{
    padding: 40px 12px;
    .HomeTwo_Title{
      margin-bottom: 28px ;
      
    }
    .HomeTwo_Options{
      .HomeTwo_Options_Details {
        width: 100%; /* 在更小螢幕時，讓每個 .options 佔滿整行 */

        a{
          .HomeTwo_Options_Details_a_p{
            font-size: 16px;
          }
        }
      }
    }
  }
}
</style>