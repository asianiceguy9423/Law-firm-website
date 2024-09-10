<template>
  <div class="home_3page">
    <img :src="currentHomeThreePICImageUrl" data-aos="fade-right" data-aos-duration="2000">
    <div class="text_div">
      <h1 class="title">{{ title }}</h1>
      <p class="text">{{ content }}</p>
      <p class="btn">{{BtnFont}}</p>
    </div>
    

    
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
    currentImage:{
      type: String,
      default:''
    },
    content:{
      type: String,
      default:''
    },
  },
  computed: {
    currentHomeThreePICImageUrl() {
      return `${this.$apiurl}/src/assets/home/${this.currentImage}`;
}
  },
}

</script>

<style scoped>
.home_3page{
  display: flex;
  align-items: center;
  background-color: rgb(0, 0, 0);
}
img{
  width: 55%;
  height: auto;
  object-fit: cover;
}
.text_div{
  color: #fff;
  padding: 0 30px;
}
.text{
  padding: 15px 0;
  padding-bottom: 30px;
}
.btn{
  font-size: 30px;
  color: rgb(214, 185, 105);
  border: 2px solid rgb(214, 185, 105);
  display: inline-block;
  padding: 5px 25px;
  cursor: pointer;
  transition: 0.3s;
}
.btn:hover{
  background-color: rgba(214, 185, 105, 0.3);
  color: #fff;
}

@media(max-width: 1250px){
  .home_3page{
    flex-direction: column;
    justify-content: center;
  }
  img{
    width: 100%;
    opacity: 0.35 !important;
  }
  .text_div{
    position: absolute;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    margin: 0 30px;
  }
}


</style>