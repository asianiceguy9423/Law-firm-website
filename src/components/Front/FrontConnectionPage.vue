<template>
  <div>
    <div class="pageBanner">
      <h1 class="bannerTitle">{{ BannerTitle }}</h1>
      <img :src="currentBannerUrl">
    </div>
    <div class="pageConnection">
      <h1 class="title" data-aos="fade-zoom-in">{{ Title }}</h1>
      <div class="ConnectionAll" data-aos="fade-up"
      data-aos-duration="1500">
        <div class="Connection"
        v-for="(information) in informations" :key="information.id">
          <h2 class="bigText">{{ information.project  }}</h2>
          <span>{{ information.explain_project }}</span>
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
      BannerTitle:'',
      Title:'',
      current_image: '',
      informations:[],
    }
  },
  computed: {
    currentBannerUrl() {
      return `${this.$apiurl}/src/assets/contact/${this.current_image}`;
    },
  },
  created() {
    this.fetchDetails();
    this.fetchInformation();
  },  
  methods:{
    redirectToUrl(){
      window.open("https://page.line.me/489jtiwj","_blank");
    },
    fetchDetails(){
      axios.get(`${this.$apiurl}/api/Add&UpdateContactPage.php`)
      .then(response =>{
        const data = response.data;
        if(data.success){
          const contact = data.contact;
          this.BannerTitle = contact.banner_title;
          this.Title = contact.title;
          this.current_image = contact.image_name;
        }else{
          this.$bus.$emit('setErrorMessage', `${data.message}`);
        }
      })
      .catch(error =>{
        this.$bus.$emit('setErrorMessage', `${error.message}`);
        console.error(error);
      })
      window.scrollTo(0,0);
    },
    fetchInformation(){
      axios.get(`${this.$apiurl}/api/FetchContactPageINformation.php`)
      .then(response =>{
        const dataInformation = response.data;
        if(dataInformation.success){
          this.informations = dataInformation.information;
        }
      })
      .catch(error =>{
        console.log(error.message);
      })
    },
  }
}
</script>

<style scoped>
.pageBanner{
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
.pageBanner img{
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
.pageConnection{
  width: 100%;
  height: auto;
  background-color: #fff;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 100px 0;
}
h1{
  text-align: center;
}
.title{
  margin-bottom: 50px;
}
.ConnectionAll{
  display: flex;
  flex-direction: column;
  flex-wrap: wrap;
  row-gap: 16px;
}
.Connection{
  display: flex;
  flex-wrap: wrap;
  align-items: center;
}
h2{
  font-size: 20px;
  font-weight: bold;
  font-weight: 700;
  color: rgb(174, 151, 88);
  width: 88px;
  margin-right: 16px;
}
span{
  color: black;
  
  font-weight: lighter;
  font-size: 20px;
}
gmp-map {
  margin-top: 70px;
  margin-bottom: 100px;
  height: 300px;
  width: 80%;
}
</style>