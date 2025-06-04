<template>
  <div 
    class="homeThree"
    :style="styleVars"
  >
    <img 
    class="homeThree_img"
      v-lazy="image" 
      alt=""
      data-aos="fade-right"
    >
    <div class="homeThree_content">
      <h1 class="homeThree_content_h1">{{ title }}</h1>
      <p class="homeThree_content_p">{{ content }}</p>
      <router-link to="/Contact">
        {{ buttonText }}
      </router-link>
    </div>
  </div>
</template>

<script>
import { computedStyleVars } from '@/utils/tools';
import { onMounted, onUnmounted, ref } from 'vue';

export default {
  props:{
    image:{
      type:     String,
      default:  ''
    },
    content:{
      type:     String,
      default:  ''
    },
    buttonText:{
      type:     String,
      default:  ''
    },
    title:{
      type:     String,
      default:  ''
    },
  },
  setup(props){
    const windowWidth = ref(window.innerWidth);
    // 監聽視窗變化
    const updateWidth = () => {
      windowWidth.value = window.innerWidth;
    };

    onMounted(() => {
      updateHeight();
      window.addEventListener('resize', updateHeight);
      window.addEventListener( 'resize', updateWidth );
    });

    onUnmounted(() => {
      window.removeEventListener( 'resize', updateWidth );
      window.removeEventListener('resize', updateHeight);
    });

    //監聽 .homeThree 的高度
    const homeThreeHeight = ref(0);

    const updateHeight = () => {
      const element = document.querySelector('.homeThree');
      if (element) {
        homeThreeHeight.value = element.offsetHeight + 'px';
      }
    };

    const styleVars = computedStyleVars(()=>  windowWidth.value <= 1024 ? props.image : '');

    return{
      styleVars,
    }
  }
}
</script>

<style lang="scss" scoped>
.homeThree{
  position: relative;
  display: flex;
  height: auto;
  width: 100%;
  align-items: center;
  box-sizing: border-box;

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
      background-color: black;
    }
    &::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
      background-color: black;
      opacity: 0.6; // 越高越深
      z-index: -1; // 蓋在圖片上，但在內容下
    }

  .homeThree_img{
    width: 55%;
    height: auto;
    object-fit: cover;
  }
  .homeThree_content{
    display: inline-block;
    padding: 0 28px;
    color: rgb(var(--secondary-color-rgb));

    .homeThree_content_h1{
      font-weight: 400;      
    }
    .homeThree_content_p{
      padding-top: 12px;
      padding-bottom: 28px;
      text-shadow: black 1px 0px 10px;
    }
    a{
      display: inline-block;
      width: auto;
      font-size: 20px;
      color: rgb(var(--main-color-rgb));
      border: 1px solid rgb(var(--main-color-rgb));
      border-radius: 2px;
      padding: 8px 24px;
      cursor: pointer;
      transition: 0.3s;
    }
    a:hover{
      background-color: rgba(var(--main-color-rgb),0.3);
      color: rgb(var(--secondary-color-rgb));
    }
  }
}
@media (max-width: 1024px) {
  .homeThree{
    flex-direction: column;
    padding: 60px 0px;
    
    .homeThree_img{
      display: none;
    }
    .homeThree_content{
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      z-index: 3;

      a{
        font-size: 18px;
      }
    }
  }  
}
@media (max-width:768px) {
  .homeThree{
    flex-direction: column;
    padding: 40px 20px;

    .homeThree_content{
      width: 100%;
    }
  }
}
</style>