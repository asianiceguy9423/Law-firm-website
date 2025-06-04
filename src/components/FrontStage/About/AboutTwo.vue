<template>
  <div 
    class="Main_Character_Introduction"
    :style="styleVars"
    >
    <div class="PersonImage_And_Content">
      <img 
        :src="personIMG"
        alt="PersonImage"
        class="Person_Image_768"
      >
      <div class="text_Box">
        <h1>{{ title }}</h1>
        <p>{{ content }}</p>
      </div>
      <img 
        :src="personIMG"
        alt="PersonImage"
        class="Person_Image_1280"
      >
    </div>
  </div>
</template>

<script>
import { computedStyleVars } from '@/utils/tools';

export default {
  props:{
    title:{
      type:     String,
      default:  ''
    },
    content:{
      type:     String,
      default:  ''
    },
    personIMG:{
      type:     String,
      default:  ''
    },
  },
  setup() {
    const styleVars = computedStyleVars();

    return {
      styleVars
    }
  }
}
</script>

<style lang="scss" scoped>
.Main_Character_Introduction{
  display: flex;
  width: 100%;
  height: auto;
  align-items: center;
  justify-content: center;
  background-color: rgb(var('--secondary-color-rgb'));
  padding: 20px 48px;
  box-sizing: border-box;

  .PersonImage_And_Content{
    display: flex;
    align-items: center;
    justify-content: center;

    .Person_Image_768{
      display: none;
    }

    .text_Box{
      width: 80%;
      max-width: 700px;

      h1{
        font-weight: 400;
      }
      p{
        padding: 20px 0;
        white-space: pre-line;
      }
    }
    .Person_Image_1280{
      width: auto;
      height: 80%;
      max-height: 650px;
      object-fit: cover;
      margin-left: 28px;
    }
  }
}
@media (max-width: 1024px) {
  .Main_Character_Introduction{
    padding: 20px 24px;
  }
  .Person_Image_1280{
    height: 500px !important;
  }  
  p{
    font-size: 16px !important;
  }
}
@media (max-width: 768px) {
  .Main_Character_Introduction{
    padding: 20px 16px;

    .PersonImage_And_Content{
      display: flex;
      flex-direction: column;

      .Person_Image_768{
        display: flex;
        width: 70%;
        max-width: 400px;
        height: auto;
        object-fit: cover;
      }
      .Person_Image_1280{
        display: none;
      }
      .text_Box{
        text-align: center;
        width: 100%;
        float: none;

        h1{
          font-size: 28px;
          color: rgb(var(--main-color-rgb));
          padding-top: 16px;
          padding-bottom: 12px;
        }
        p{
          padding: 0;
        }
      }
    }
  }
}
</style>