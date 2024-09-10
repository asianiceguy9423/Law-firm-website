<template>
  <div>
    <FrontHomeOne
    :title = "HomeOneTitle"
    :BtnFont = "HomeOneBtn"
    :curentImage = "currentHomeOne_image"/>
    <FrontHomeTwo/>
    <FrontHomeThree
    :title="HomeThreeTitle"
    :BtnFont="HomeThreeBtn"
    :currentImage = "currentHomeThree_image"
    :content="HomeThreeContent"/>
  </div>
  
</template>

<script>
import axios from 'axios';
import FrontHomeOne from './FrontHomeOne.vue'
import FrontHomeTwo from './FrontHomeTwo.vue'
import FrontHomeThree from './FrontHomeThree.vue';
export default {
  components:{
    FrontHomeOne,
    FrontHomeTwo,
    FrontHomeThree
  },
  data(){
    return{
      HomeOneTitle:'',
      HomeOneBtn:'',
      currentHomeOne_image: '',
      HomeTwoTitle:'',
      HomeThreeTitle:'',
      HomeThreeContent:'',
      HomeThreeBtn:'',
      currentHomeThree_image: '',
    }
  },
  created(){
    this.fetchDetails();
  },
  methods:{
    fetchDetails(){
      axios.get(`${this.$apiurl}/api/FetchHomePage.php`)
      .then(response => {
        const data = response.data;
        if (data.success) {
          const home = data.home;
          this.HomeOneTitle = home.home_one_title;
          this.HomeOneBtn = home.home_one_btn;
          this.currentHomeOne_image = home.home_one_image;
          this.HomeTwoTitle = home.home_two_title;
          this.HomeThreeTitle = home.home_three_title;
          this.HomeThreeContent = home.home_three_content;
          this.HomeThreeBtn = home.home_three_btn;
          this.currentHomeThree_image = home.home_three_image;
        }
      })
      .catch(error =>{
        console.error(error);
      })
      window.scrollTo(0,0);
    }
  }
}
</script>

<style>
</style>