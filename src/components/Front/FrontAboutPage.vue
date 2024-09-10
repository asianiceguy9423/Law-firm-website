<template>
  <div>
    <FrontAboutOne
    :title ="AboutOneTitle"
    :writings ="AboutOneSubTitle"
    :image ="currentImageOne"/>
    <FrontAboutTwo
    :title ="AboutTwoTitle"
    :writings ="AboutTwoWritings"
    :image ="currentImageTwo"/>
    <FrontAboutThree
    :bkImage = "AboutThreeBackgrondImage"/>

  </div>  
</template>

<script>
import axios from 'axios';
import FrontAboutOne from './FrontAboutOne.vue';
import FrontAboutTwo from './FrontAboutTwo.vue';
import FrontAboutThree from './FrontAboutThree.vue';


export default {
  components:{
    FrontAboutOne,
    FrontAboutTwo,
    FrontAboutThree    
  },
  data(){
    return{
      isSmallScreen: false,
      AboutOneTitle:'',
      AboutOneSubTitle:'',
      currentImageOne: '',
      AboutTwoTitle:'',
      AboutTwoWritings:'',
      currentImageTwo:'',
      AboutThreeBackgrondImage:'',
    }
  },
  created(){
    this.fetchDetails();
    this.$bus.$on('checkScreenSize', this.checkScreenWidth);
  },
  mounted(){
    this.checkScreenWidth();
    window.addEventListener('resize', this.checkScreenWidth);
  },
  beforeDestroy(){
    window.removeEventListener('resize', this.checkScreenWidth);
    this.$bus.$off('checkScreenSize');
  },
  methods:{
    checkScreenWidth(){
      this.isSmallScreen = window.innerWidth <= 1250;
      this.$bus.$emit('ScreenSize', this.isSmallScreen);
    },
    fetchDetails() {
      axios.get(`${this.$apiurl}/api/FetchAboutPage.php`)
      .then(response =>{
        const data = response.data;
        if(data.success){
          const about = data.about;
          this.AboutOneTitle = about.about_one_title;
          this.AboutOneSubTitle = about.about_one_subtitle;
          this.currentImageOne = about.about_one_image;
          this.AboutTwoTitle = about.about_two_title;
          this.AboutTwoWritings = about.about_two_writings;
          this.currentImageTwo = about.about_two_image;
          this.AboutThreeBackgrondImage = about.about_three_BK;
        }
      })
      .catch(error => {
        console.error(error);
      });
      window.scrollTo(0,0);
    },
  }  
}
</script>

<style scoped>
*{
  background-color: black;
}
</style>