<template>
  <div >
    <div class="banner">
      <h1 class="bannerTitle">{{ TrafficTitle }}</h1>
      <img :src="currentBannerPICImageUrl">
    </div>

    <div class="chapterPage">
      <div class="chapterAll" 
      data-aos="fade-up"
      data-aos-duration="1500">
        <router-link class="chapter"
        v-for="law in filteredLaws" :key="law.id"
        :to="`/LawWritings/${law.id}`">
          <div class="imageDiv">
            <img v-if="law.big_image" :src="getImagUrl(law.big_image)">
            <h2 class="chapterTitle">{{ law.title }}</h2>       
          </div>      
          <p class="explain">{{ law.text_point }}</p>
        </router-link>

        <div class="chapter"
        v-if="displayWritings">
          <a href="#">
            <div class="imageDiv">
              <img :src="currentFuturePICImageUrl">
              <h2 class="chapterTitle">{{ FutureTitle }}</h2>       
            </div>      
            <p class="explain">{{ FutureText }}</p>
          </a>        
        </div>   
          
      </div>
    </div>
  </div> 
</template>

<script>
import axios from 'axios';

export default {
  data(){
    return{
      laws: [],
      TrafficTitle:'',
      currentTrafficImage:'',
      FutureTitle:'',
      FutureText:'',
      currentFutureImage:'',
      displayWritings: false,
    }
  },
  created(){
    this.fetchDetails();
    this.fetchBannerDetails();
  },
  computed:{
    filteredLaws(){
      return this.laws.filter(law => law.class.includes('車禍'));
    },
    currentBannerPICImageUrl() {
      return `${this.$apiurl}/src/assets/law/${this.currentTrafficImage}`;
    },
    currentFuturePICImageUrl() {
      return `${this.$apiurl}/src/assets/law/${this.currentFutureImage}`;
    }
  },
  methods:{
    fetchDetails() {
      axios.get(`${this.$apiurl}/api/fetchLawWriting.php`)
        .then(response => {
          const data = response.data;
          if (data.success) {
            this.laws = data.law;
          }
        })
        .catch(error => {
          console.error(error.message);
        })
        window.scrollTo(0,0);
    },
    getImagUrl(image) {
      return `${this.$apiurl}/src/assets/law/${image}`; 
    },
    fetchBannerDetails() {
      axios.get(`${this.$apiurl}/api/FetchLawBannerPage.php`)
        .then(response => {
          const data = response.data;
          if (data.success) {
            const law = data.law;
            this.TrafficTitle = law.law_traffic_title;
            this.currentTrafficImage = law.law_traffic_image;
            this.FutureTitle = law.law_future_title;
            this.FutureText = law.law_future_text;
            this.currentFutureImage = law.law_future_image;
            this.displayWritings = law.law_future_display == 1 ? true : false;
        }
      })
      .catch(error => {
          console.error(error.message);
      });
    },
  }  
}
</script>

<style scoped>
.banner{
  position: relative;
  width: 100%;
  height: 400px;
  padding-top: 100px;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: black;
}
.bannerTitle{
  font-size: 50px;
  color: #fff;
  z-index: 2;
  }
.banner img{
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 500px;
  object-fit: cover;
  opacity: 0.3;
}
@media(max-width:700px){
  h1{
    font-size: 40px;
  }
}
.chapterPage{
  box-sizing: border-box;
  padding: 0 60px;
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
  height: auto;
  background-color: #fff;
}
.chapterAll{
  width: 100%;
  display: grid;
  grid-template-columns: 1fr 1fr 1fr 1fr;
  column-gap: 16px;
  row-gap: 40px;
  margin: 100px 0;
}  
.chapter{
  display: flex;
  flex-direction: column;
  width: 100%;
  height: 260px;
  box-shadow: rgb(209, 209, 209) 1px 1px 10px;
  cursor: pointer;
}
.imageDiv{
  position: relative;
  height: 200px;
  width: 100%;
  display: flex;
  justify-content: center;
  overflow: hidden;  
}
.chapter img{
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: 0.3s;
}
.chapter:hover img{
  opacity: 0.5;
}
h2{
  position: absolute;
  width: 90%;
  top: 80px;
  text-align: center;
  color: #fff;
  font-size: 30px;
  font-weight: bold;
  text-shadow: rgb(6, 6, 6) 1px 1px 20px;
  transition: 0.3s;
  display: inline;
}
.chapter:hover h2{
  top:60px;
}
.explain{
  font-size: 1rem;
  color: #1a1a1a;
  padding: 8px 12px;
}
@media (max-width: 1500px) {
  .chapterAll{
    grid-template-columns: 1fr 1fr 1fr;
  }
}
@media (max-width: 1250px) {
  .chapterPage{
  padding: 0 20px;
  }
  .chapterAll{
    grid-template-columns: 1fr 1fr;
  }
}
@media (max-width: 750px) {
  .chapterAll{
    display: grid;
    grid-template-columns: 1fr;
    justify-content: center;
    align-items: center;
    row-gap: 40px;
  } 
  .chapter{
    max-width: none;
    width: 100%;
    height: 320px;
  }
  .imageDiv{
    height: 280px;
  }
  .explain{
    text-align: center;
  }
}
</style>