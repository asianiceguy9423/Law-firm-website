<template>
  <button 
    :style="styleVars"
    @click="scrollToTop"
  >
    TOP
  </button>
</template>

<script>
import { computedStyleVars } from '@/utils/tools'

export default {
  setup(){
    const scrollToTop = () =>{
      window.scroll({
        top:0,
        behavior:'smooth'
      })
    }

    const styleVars = computedStyleVars();
    return{
      scrollToTop,
      styleVars
    }
  }
}
</script>

<style lang="scss" scoped>
button{
  position: fixed;
  bottom: 20px;
  right: 20px;
  padding: 20px 15px;
  background-color: color-mix(in srgb, rgb(var(--main-color-rgb)) 75%, black 25%);
  color: rgb(var(--secondary-color-rgb));
  border: none;
  border-radius: 50px;
  cursor: pointer;
  z-index: 1000;
  transition: 0.3s
}
button:hover {
  background-color: rgb(var(--main-color-rgb));
}
</style>