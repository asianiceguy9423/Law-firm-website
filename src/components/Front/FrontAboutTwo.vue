<template>
  <div class="AboutTwo">
    <div class="textAndImageDiv">
      <img class="personImageLeft" 
      :src="currentImageUrl"  
      data-aos="fade-left"
      data-aos-duration="2000">
      <div class="textDiv" 
      data-aos="fade-right"
      data-aos-duration="2000">
        <h1>{{ formattedtitle }}</h1>
        <p class="text">
         {{ writings }}
        </p>     
      </div>
      <img class="personImageRight" 
      :src="currentImageUrl" 
      data-aos="fade-left"
      data-aos-duration="2000">
    </div>       
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
      type: String,
      default:''
    },
    writings:{
      type: String,
      default:''
    },
    image:{
      type: String,
      default:''
    },
  },
  created(){
    this.$bus.$on('ScreenSize', this.handleScreenSize);
  },
  beforeDestroy(){
    this.$bus.$off('ScreenSize', this.handleScreenSize);
  },
  mounted(){
    this.$bus.$emit('checkScreenSize');
  },
  computed:{
    currentImageUrl(){
      return `${this.$apiurl}/src/assets/about/${this.image}`;
    },
    formattedtitle(){
      if(this.isSmallScreen && this.title.includes(' ')){
        return this.title.replace(' ','\n');
      }
      return this.title;
    }    
  },
  methods:{
    handleScreenSize(isSmall) {
      this.isSmallScreen = isSmall;
    },
  }
  
}
</script>

<style scoped>
h1{
  font-weight: 400;
}
.AboutTwo{
  background-color: #fff;
  width: 100%;
  height: 90vh;
  display: flex;
  align-items: center;
  justify-content: center;
  box-sizing: border-box;
  padding: 100px 50px;
}
.textAndImageDiv{
  display: flex;
  align-items: center;
  justify-content: center;
}
.textDiv{
  max-width: 700px;
  width: 80%;
}
.text{
  line-height: 30px;
  padding: 20px 0;
  white-space: pre-line;
}
.personImageRight{
  width: auto;
  max-height: 650px;
  height: 80%;
  object-fit: cover;
  margin-left: 28px;
}
.personImageLeft{
  display: none;
}
@media(max-width:1250px){
  .personImageRight{
    height: 500px;
    margin-left: 28px;
}
}
@media(max-width:1000px){
  h1{
    color: rgb(174, 151, 88);
    padding-top: 30px;
    padding-bottom: 20px;
  }
  .AboutTwo{
    height: auto;
    text-align: center;
    padding: 100px 20px;
  }
  .personImageLeft{
    display: flex;
    width: 70%;
    max-width: 400px;
    height: auto;
    object-fit: cover;
  }
  .personImageRight{
    display: none;
  }
  .textAndImageDiv{
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: none;    
  }
  .textDiv{
    width: 100%;
    float: none;
  }
  .text{
  padding: 0;
  } 
}
@media (max-width:600px) {
  h1{
    font-size: 30px;
  }
}
</style>