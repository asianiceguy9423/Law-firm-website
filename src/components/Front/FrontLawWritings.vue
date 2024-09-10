<template>
  <div>
    <div class="banner">
      <h1 class="bannerTitle">法律資訊文章</h1>
      <img :src="currentBannerUrl">
    </div>

    <div class="writingsPage">
      <div class="NavigationAndTitle">
        <div class="NavigationLink">
          <router-link to="/Home">
            <button class="NavigationLinkBtn" type="button">
            首頁
          </button>
          </router-link>
          >
          <button class="NavigationLinkBtn" type="button" @click="goBack">
            交通
          </button>
          >
          <button class="NavigationLinkBtn"  type="button">
            本文title
          </button>
        </div>
        <div class="TitleAndLabelDiv">
          <h2 class="WritingsTitle">{{ LawTitle }}</h2>
          <button class="label" type="button" @click="goBack">車禍</button>
        </div>        
      </div>

      <div class="WritingsContent">
        <img class="up_image" :src="currentBigImageUrl">
        <div class="putIn" v-html="LawText"></div>

          <button>開始免費諮詢</button>   
        <div class="under_text">
          <p>
            ※聲明：
          </p>
          <li>
            著作權由「老周好帥」及「Chatgpt」合作書寫。
          </li>
          <li>
            文章資料內容僅供參考，不宜直接引用為主張或訴訟用途，具體個案仍請洽詢專業律師。
          </li>
          <li>
            法令具時效性，文章內容及所引用資料，請自行查核法令動態及現行有效之實務見解。
          </li>      
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
      id : this.$route.params.id,
      LawTitle:'',
      LawClass:[],
      LawText: '',
      current_banner:'',
      current_big_image:'',
    }
  },
  computed:{
    currentBannerUrl(){
      return `${this.$apiurl}/src/assets/law/${this.current_banner}`;
    },
    currentBigImageUrl(){
      return `${this.$apiurl}/src/assets/law/${this.current_big_image}`;
    },
  },
  created(){
    this.fetchLawDetails();
  },
  methods:{
    fetchLawDetails(){
      axios.get(`${this.$apiurl}/api/UpdateLawWriting.php?id=${this.id}`)
      .then(response =>{
        const data = response.data[0];
        if (data) {
            this.LawTitle = data.title;
            this.LawClass = (data.class || '').split(',').filter(item => item !== '');
            this.LawText = data.text;
            this.current_banner  = data.banner_image;
            this.current_big_image  = data.big_image;
        }
      })
      .catch(error => {
        console.error(error.message);
      });
      window.scrollTo(0,0);
    },
    goBack() {
      this.$router.go(-1);
    }
  }
  
}
</script>

<style scoped>
.banner{
  position: relative;
  width: 100%;
  height: 400px;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: black;
}
.bannerTitle{
  /* margin-top: 100px; */
  font-size: 50px;
  color: #fff;
  z-index: 2;
  }
.banner img{
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 400px;
  object-fit: cover;
  opacity: 0.3;
}

/*這是page2*/
.writingsPage{
  width: 100%;
  height: auto;
  background-color: #fff;
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 0 20px;
  box-sizing: border-box;
}
.NavigationAndTitle{
  padding: 50px 0;
  width: 80%;
}
.NavigationLink{
  width: 100%;
  border-bottom: 1px solid #333333;
  padding-bottom: 10px;
}
.NavigationLinkBtn{
  border: none;
  border-radius: 40px;
  padding: 4px 10px;
  font-size: 14px;
  cursor: pointer;
  background-color: #fff;
  transition: 0.3s;
}
.NavigationLinkBtn:hover{
  background-color: #eceff3;
}
.TitleAndLabelDiv{
  padding-top: 64px;
}
.WritingsTitle{ 
  font-size: 40px;
}
.label{
  display: inline-block;
  margin-top: 15px;
  font-size: 18px;
  padding: 10px 15px;
  border: 1px solid #333333;
  border-radius: 50px;
  background: none;
  cursor: pointer;
  transition: 0.3s;
}
.label:hover{
  border-color: rgb(174, 151, 88);
  color: rgb(174, 151, 88);
}
/*這是page3*/
.WritingsContent{
  width: 80%;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.up_image{
  width: 80%;
  height: auto;
  object-fit: cover;
}
/deep/ .h3Div{
  width: 100%;
  border-top: 3px solid rgb(174, 151, 88);
  border-bottom: 3px solid rgb(174, 151, 88);
  padding: 16px 0px;
  margin: 50px 0;
}
/deep/h3{
  text-align: center;
  font-size: 24px;
  white-space: pre-line;
}
/deep/h4{
  width: 100%;
  font-size: 24px;
  font-weight: bold;
  padding: 12px 0;
}
/deep/p,
/deep/li{
  width: 100%;
  font-size: 20px;
  line-height: 30px;
  list-style-type: disc;
}
/deep/span{
  font-weight: bold;
}
.WritingsContent button{
  font-size: 25px;
  font-weight: bold;
  color: #fff;
  border-radius: 50px;
  border-style: none;
  background: rgb(174, 151, 88);
  padding: 15px 35px;
  margin: 35px 0;
  transition: 0.4s;
  cursor: pointer;
}
.WritingsContent button:hover{
  background: rgb(214, 185, 105);
}
.putIn{
  width: 100%;
}
.under_text{
  text-align: left;
  width: 100%;
  margin-bottom: 50px;
}
.under_text p,
.under_text li{
  font-size: 15px;
  line-height: 20px;
}
@media(max-width:850px){
  /deep/p{
    font-size: 16px;
  }
  .NavigationAndTitle,
  /deep/.WritingsContent{
  width: 100%;
}
}
</style>