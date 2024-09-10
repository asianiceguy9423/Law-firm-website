<template>
  <div class="home_2page">
    <h1 class="title" data-aos="fade-zoom-in">
      服務項目
    </h1>        
    <div class="case_all" 
    data-aos="fade-up"
    data-aos-duration="1500">
      <div class="case" 
      v-for="(happening) in happenings" :key="happening.id">
        <img :src="getImagUrl(happening.home_two_image)">
        <h1 class="caseTitle">{{ happening.home_two_title }}</h1>
        <p class="caseText">{{ happening.home_two_exp }}</p>
      </div>
    </div>    
  </div>
</template>

<script>
import axios from 'axios';
export default {
  data(){
    return{
      happenings:[],
    }
  },
  created(){
    this.fetchDetails();
  },
  methods:{
    getImagUrl(home_two_image){
        return `${this.$apiurl}/src/assets/home/${home_two_image}`;      
      },
    fetchDetails(){
      axios.get(`${this.$apiurl}/api/fetchHomePageTwo.php`)
      .then(response =>{
        const data = response.data;
        if(data.success){
          this.happenings = data.happening;
        }
      })
      .catch(error =>{
        console.error(error);
      })
    },
  }
}
</script>

<style scoped>
.home_2page {
  background-color: black;
  height: auto;
  width: 100%;
  padding: 100px 0px;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.title{
  color: #fff;
}
.case_all{
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  column-gap: 16px;
  padding: 100px 30px;
  box-sizing: border-box;
}
.case{
  background-color: #2d2d2d;
  width: 275px;
  height: 300px;
  cursor: pointer; 
  display: flex;
  flex-grow: 1;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  transition:  1s
}
.case:hover{
  transition:  1s;
  background: linear-gradient(0deg, rgba(135,122,65,1) 0%, rgba(66,60,32,1) 23%, rgba(0,0,0,1) 100%);
  margin-top: -15px;
}
img{
  height: 90px;
  width: auto;
  object-fit: cover;  
}
.case:hover img{
  display: none;
}
.caseTitle{
  color: rgb(214, 185, 105);
  margin-top: 20px;
}
.caseText{
  color: #fff;
  font-size: 20px;
}
@media(max-width: 1250px){
  .case_all{
    padding-bottom: 0;
  }
  .case{
    width: calc(50% - 8px); /* 每行两个元素 */
    margin-bottom: 16px;
  }
}

</style>