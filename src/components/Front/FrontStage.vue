<template>
  <div>
    <FrontNavbar/>
    <router-view/>
    <FrontFooter/>
  </div>
</template>

<script>
import FrontFooter from './FrontFooter.vue';
import FrontNavbar from './FrontNavbar.vue';

export default {
  components:{
    FrontFooter,
    FrontNavbar,
  }

}
</script>

<style>
a{
    font-family: "Noto Sans TC", sans-serif, Arial;
  }
body{
  min-height: 100vh;
  height: auto;
}
li{
  list-style: none;
}
h1{
  font-size: 40px;
  font-weight: normal;
}
p{
  font-size: 20px;
  line-height: 30px;
}

</style>