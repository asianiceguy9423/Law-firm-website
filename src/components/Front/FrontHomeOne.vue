<template>
  <div class="home_1page">
    <div>
      <p class="title">{{ title }}</p>
      <p class="BtnFont">{{ BtnFont }}</p>
      </div>
    <img :src="currentHomeOnePICImageUrl" 
    data-aos="fade-zoom-in"
    data-aos-duration="3000">      
  </div>
</template>

<script>
export default {
  props:{
    title:{
      type: String,
      default:''
    },
    BtnFont:{
      type: String,
      default:''
    },
    curentImage:{
      type: String,
      default:''
    }
  },
  computed:{
    currentHomeOnePICImageUrl(){
      return `${this.$apiurl}/src/assets/home/${this.curentImage}`;
    }
  }
}
</script>

<style scoped>
.home_1page{
  width: 100%;
  height: auto;
  display: flex;
  align-items: center;
  position: relative;
  color: rgb(214, 185, 105);
}
.home_1page div{
  position: absolute;
  margin-top: 50px;
  margin-left: 100px;
  z-index: 100;
}
.title{
  font-size: 40px;
  padding: 10px 0;
}
.BtnFont{
  display: inline-block;
  font-size: 30px;
  cursor: pointer;
  transition:  0.5s;
}
.BtnFont:hover{
  background-color: rgba(214, 185, 105, 0.3);
  padding: 0 25px;
  color: #fff;
}
img{
  height: 100vh;
  width: 100%;
  object-fit: cover;
}
@media(max-width: 1250px){
  .home_1page{
    top: 100px;
    padding-bottom: 100px;
  }
  .home_1page div{
    margin-top: 0px;
  }
  img{
    height: auto;
  }
}
</style>