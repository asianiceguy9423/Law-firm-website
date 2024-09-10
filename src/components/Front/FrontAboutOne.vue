<template>
  <div class="AboutOne">
    <div class="textDiv" 
    data-aos="fade-zoom-in" 
    data-aos-duration="2000">
      <h1 class="title">{{title}}</h1>
      <h1 class="text">{{ formattedWritings }}</h1>

    </div>
    <img :src="currentImageUrl">
  </div>  
</template>

<script>
export default {
  data() {
    return {
      isSmallScreen: false,
    };
  },
  props:{
    title:{
      type:String,
      default:''
    },
    writings:{
      type:String,
      default:''
    },
    image:{
      type:String,
      default:''
    },
  },
  created(){
    this.$bus.$on('ScreenSize', this.handleScreenSize);
  },
  mounted(){
    this.$bus.$emit('checkScreenSize');
  },
  beforeDestroy(){
    this.$bus.$off('ScreenSize', this.handleScreenSize);
  },
  computed: {
    currentImageUrl() {
      return `${this.$apiurl}/src/assets/about/${this.image}`;
    },
    formattedWritings(){
      if(this.isSmallScreen && this.writings.includes(' ')){
        return this.writings.replace(' ','\n');
      }
      return this.writings;
    }
  },
  methods: {
    handleScreenSize(isSmall) {
      this.isSmallScreen = isSmall;
    },
  },
}
</script>

<style scoped>
.AboutOne{
  width: 100%;
  height: 100vh;
  color: #fff;
  display: flex;
  justify-content: center;
  align-items: center;
  box-sizing:border-box;
  padding: 0 30px;
}
.textDiv{
  z-index: 1;
  text-shadow: #333333 1px 0px 10px;
  text-align: center;
}
.title{
  font-size: 50px;
  padding: 20px 0;
}
.text{
  font-size: 100px;
  border-top: 1.5px solid #fff;
  padding: 10px 0;
  white-space: pre-line;
}
img{
  position: absolute;
  object-fit: cover;
  width: 100%;
  height: 100vh;
  opacity: 0.5;
}
@media(max-width:1250px){
  .title{
    font-size: 40px;
  }
  .text{
    font-size: 80px;
  }
}
</style>