<template>
  <div 
    class="AboutBanner"
    :style="styleVars"
  >
    <div 
      class="textBox"
      data-aos="fade-zoom-in"
      :style="h1Color"
    >
      <h1>
        {{ title.title }}
      </h1>
      <h2 :style="h2Style">{{ title.subtitle }}</h2>
    </div>
  </div>
</template>

<script>
import { computedStyleVars } from '@/utils/tools';
import { computed } from 'vue';

export default {
  props: {
    bannerIMG: {
      type: String,
      default: '',
    },
    title: {
      type: Object,
      default: () => ({}),
    },
  },
  setup(props){
    const h1Color = computed(() => {
      const shadowColor = props.title?.shadow ? props.title.mainColor : '0,0,0';
      const textColor   = whiewColor.value;
      return {
        color: `rgb(${textColor})`,
        textShadow: `rgb(${shadowColor}) 1px 0px 10px`,
      };
    });

    const h2Style = computed(() => {
      const textColor   = whiewColor.value;
      return {
        color: `rgb(${textColor})`,
        borderTop: `1.8px solid rgb(${textColor})`,
      }
    });

    const styleVars = computedStyleVars(()=> props.bannerIMG);

    const whiewColor = computed(()=>{
      const color = styleVars.value['--secondary-color-rgb'];
      return color || '0,0,0'
    })

    return{
      h1Color,
      h2Style,
      styleVars,
    }
  }
}
</script>

<style lang="scss" scoped>
.AboutBanner{
  position: relative;
  display: flex;
  width: 100%;
  height: 100vh;
  justify-content: center;
  align-items: center;
  box-sizing: border-box;
  padding: 0 12px;

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
      background-color: white;
      opacity: 0.5; // 越高越深
      z-index: -1; // 蓋在圖片上，但在內容下
    }

  .textBox{
    text-align: center;
    text-shadow: rgb(51, 51, 51) 1px 0px 10px;
    z-index: 3;

    h1{
      font-size: 100px;
      padding: 20px 0;
    }
    h2{
      font-size: 60px;
    }
  }
}
@media (max-width: 1024px) {
  h1{
    font-size: 80px !important;
  }
  h2{
    font-size: 50px !important;
  }  
}
@media (max-width: 768px) {
  h1{
    font-size: 50px !important;
  }
  h2{
    font-size: 30px !important;
  }  
}

</style>