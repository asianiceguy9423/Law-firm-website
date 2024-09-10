<template>
  <div class="pageJoin" :style="backgroundStyleOpzcity">
    <div :style="backgroundBeforeStyle"></div>
    <div class="textDiv" data-aos="fade-zoom-in">
      <h1>{{ Title }}</h1>
      <P class="title_text">{{ Content }}</P>
        <button @click="redirectToUrl">加入我們</button>
      
    </div>
  </div> 
</template>

<script>
import axios from 'axios';

export default {
  data(){
    return{
      Title:'',
      Content:'',
      btnText: '',
      current_image:'',
    }
  },
  computed: {
    backgroundStyleOpzcity(){
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
        backgroundImage: `url(${this.$apiurl}/src/assets/join/${this.current_image})`,
        backgroundSize: 'cover',
        backgroundAttachment: 'fixed',
        opacity: '0.5',
        zIndex: '-1',
      }
    }
  },
  created() {
    this.fetchDetails();
  },  
  methods:{
    redirectToUrl(){
      window.open("https://page.line.me/489jtiwj","_blank");
    },
    fetchDetails(){
      axios.get(`${this.$apiurl}/api/Add&UpdateJoinPage.php`)
      .then(response =>{
        const data = response.data;
        if(data.success){
          const join = data.join;
          this.Title = join.title;
          this.Content = join.content;
          this.btnText = join.btn_text;
          this.current_image = join.image_name;
        }
      })
      .catch(error =>{
        console.error(error.message);
      })
      window.scrollTo(0,0);
    },   
  }
}
</script>

<style scoped>
.pageJoin{
  width: 100%;
  height: 100vh;
  background-color: black;
  color: #fff;
  display: flex;
  justify-content: center;
  align-items: center;
}
.textDiv{
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  z-index: 1;
  padding-top: 100px;
}
h1{
  font-size: 100px;
  text-shadow: #333333 1px 0px 10px;
  padding: 16px 0;
}
p{
  border-top: 1px solid #fff;
  padding-top: 10px;
  width: 80%;
  white-space: pre-line
}
button{
  font-size: 25px;
  font-weight: bold;
  color: #fff;
  border-radius: 50px;
  border-style: none;
  background: rgb(174, 151, 88);
  padding: 15px 35px;
  margin-top: 35px;
  transition: 0.4s;
  cursor: pointer;
}
button:hover{
  background: rgb(214, 185, 105);
}
@media(max-width:1250px){
  h1{
    font-size: 8vw;    
  }
  .text{
    font-size: 8vw;
  }
}
</style>