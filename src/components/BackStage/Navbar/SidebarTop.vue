<template>
  <div>
    <svg 
      ref="burgerButtonRef"
      @click="emitBurgerButton" 
      xmlns="http://www.w3.org/2000/svg" 
      height="32" width="28" 
      viewBox="0 0 448 512">
        <path  fill="currentColor" d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"/>
    </svg>
  </div>
</template>

<script>
import { onMounted, ref } from 'vue';
import { useStore } from 'vuex';

export default {
  setup() { 
    const store = useStore();
    const burgerButtonRef = ref(null);

    const emitBurgerButton = () => {
      store.dispatch('NavbarStore/toggleBackStageNavbar')
    };

   onMounted(() => {
      document.dispatchEvent(new CustomEvent('registerBurgerRef', {
        detail: { el: burgerButtonRef.value }
      }));
    });

    return {
      burgerButtonRef,
      emitBurgerButton,
    };
  }
}
</script>

<style lang="scss" scoped>
div{
  display: none;
  width: 100%;
  height: 64px;
  padding: 0 20px;
  justify-content: space-between;
  align-items: center;
  box-sizing: border-box;
  background-color: rgb(255, 255, 255);

  svg{
    cursor: pointer;
  }
}
@media(max-width:1024px){
  div{
    display: flex;
  }
  }

</style>