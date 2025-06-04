<template>
  <NavBar/>
    <div>
      <router-view/>
    </div>
    <ScrollToTop/>  
  <Footer/>
</template>

<script>
import Footer from './Footer/Footer.vue';
import NavBar from './NavBar/NavBar.vue';
import ScrollToTop from './ScrollToTop.vue';
export default {
  components:{
    Footer,
    NavBar,
    ScrollToTop,
  },
  setup() {}
}
</script>

<style>
</style>