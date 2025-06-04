<template>
    <div class="banner"
      :style="styleVars"
      data-aos="fade-zoom-in"  
    >
      <div class="banner_Content">
        <h1 class="banner_Content_h1">{{ title }}</h1>
        <li class="banner_Content_li">
          <router-link  to="/Contact">
            {{ buttonText }}
          </router-link>
        </li>      
      </div>
    </div>
</template>

<script>
import { computedStyleVars } from '@/utils/tools';

export default {
props: {
  bannerIMG: {
    type: String,
    default: '',
  },
  title: {
    type: String,
    default: '',
  },
  buttonText: {
    type: String,
    default: '',
  },
},
setup(props){
  //獲取顏色
  const styleVars = computedStyleVars(() => props.bannerIMG);
  
  return{
    styleVars,
  }
}
}
</script>

<style lang="scss" scoped>
  .banner{
    position: relative;
    display: flex;
    width: 100%;
    height: 100vh;
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
    
    .banner_Content{
      position: absolute;
      display: block;
      height: auto;
      width: auto;
      margin-left: 100px;
      margin-top: 50px;

      .banner_Content_h1{
        color: rgb(var(--main-color-rgb));
        font-size: 40px;
        font-weight: 400;
        padding: 12px 0;
      }
      .banner_Content_li{
        a{
          color: rgb(var(--main-color-rgb));
          font-size: 28px;
          cursor: pointer;
          transition: 0.5s;
          padding: 10px 0;
        }
        a:hover{
          color: rgb(var(--secondary-color-rgb));
          background-color: rgba(var(--main-color-rgb), 0.3);
          padding: 10px 25px;
          border-radius: 2px;
        }
      }
    }
  }
@media (max-width: 1024px) {
  .banner{
    .banner_Content{
      margin-left: 60px;
      margin-top: 0px;

      .banner_Content_h1{
        font-size: 32px;
      }
      .banner_Content_li{
        a{
          font-size: 24px;
        }
      }
    }
  }
}
@media (max-width: 768px) {
  .banner{
    .banner_Content{
      margin-left: 20px;
    }
  }
}
</style>