<template>
  <div class="aboutThree" :style="backgroundStyleWithOpacity">
    <div :style="backgroundBeforeStyle"></div>
    <h1 class="title" data-aos="fade-zoom-in">專業團隊</h1>
    <div class="information" 
    data-aos="fade-up"
    data-aos-duration="1500"
    v-for="(about) in abouts" :key="about.id">
      <img class="personImage" :src="getImagUrl(about.image_name)">
      <div class="informationText">
        <h2 class="longH2">{{ about.personName }} {{ about.position }}</h2>
        <h2 class="shortH2">{{ about.personName }} <br>  <span class="position">{{ about.position }}</span></h2>
        <h3 class="big_text">專長</h3>
        <p class="text">{{ about.skill }}</p>
        <h3 class="big_text">經歷</h3>
        <p class="text">{{ about.exp }}</p>
      </div>
    </div>

  </div>
</template>

<script>
import axios from 'axios';
export default {
  props:{
    bkImage:{
      type: String,
      default:''
    }
  },
  data(){
    return{
      abouts:{},
    }
  },
  created(){
    this.fetchabout();
  },
  computed:{
    backgroundStyleWithOpacity(){
      return{
        position: 'relative',
        zIndex: 1,
      }
    },
    backgroundBeforeStyle(){
      return{
      position: 'absolute',
      top: '0',
      left: '0',
      width: '100%',
      height: '100%',
      backgroundImage: `url(${this.$apiurl}/src/assets/about/${this.bkImage})`,
      backgroundSize: 'cover',
      backgroundAttachment: 'fixed',
      opacity: '0.3',
      zIndex: '-1',
      }
    },
  },
  methods:{
    fetchabout() {
      axios.get(`${this.$apiurl}/api/FetchAboutPageThree.php`)
      .then(response => {
        const data = response.data;
        if (data.success) {
          this.abouts = data.abouts;
        }
      })
      .catch(error => {
        console.error(error);
      });
    },
    getImagUrl(image_name) {
      return `${this.$apiurl}/src/assets/about/${image_name}`;
    },
  }
}
</script>

<style scoped>
.aboutThree{
  width: 100%;
  height: auto;
  display: flex;
  flex-direction: column;
  align-items: center;
  box-sizing: border-box;
  padding: 100px 0;
}
h1{
  color: #fff;
  margin-bottom: 50px;
}
.information{
  background-color: #fff;
  margin: 32px 0;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 28px 28px;
  height: auto;
  min-height: 400px;
  width: auto;
  max-width: 80%;
}
.personImage{
  display: flex;
  height: auto;
  width: 210px;
  object-fit: cover;
}
.informationText{
  display: flex;
  flex-direction: column;
  margin-left: 28px;
  max-width: 760px;
  width: auto;
}
h2{
  font-weight: 400;
  font-size: 36px;
  padding-bottom: 4px;
}
.position {
  font-size: 24px;
}
.shortH2{
  display: none;
}
h3{
  font-size: 24px;
  font-weight: normal;
  color: rgb(174, 151, 88);
  padding-top: 8px;
  padding-bottom: 4px;
}
.text{
  width: 100%;
}
@media(max-width:800px){
  .information{
    display: flex;
    flex-direction: column;
    text-align: center;
  }
  .informationText{
    margin: 0;
  }
  .personImage{
    display: flex;
    height: auto;
    max-width: 210px;
    width: 100%;
    object-fit: cover;
  }
  .longH2{
    display: none;
  }
  .shortH2{
    display: inline-block;
  }
  h2{
   padding: 10px 0;
  }
}

</style>