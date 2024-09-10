<template>
  <div class="AllPage" ref="rightPart">
    
    <form @submit.prevent="login" class="formPart">
      <div class="leftPart">
        <div class="LoginTitle">
          <h1>登入</h1>
          <p>歡迎使用後台操作系統</p>
        </div>
        
        <div class="userimputPart">
          <div class="error" v-if="message">{{ message }}</div>
          <div class="labelAndInput">
            <label for="username">帳號</label>
            <input type="text" v-model="username" id="username">
          </div>
          <div class="labelAndInput">
            <div class="PasswprdTitle">
              <label for="password">密碼</label>
              <div class="forgetDiv">
                <div class="forgerPassWordMessage">
                  <p class="forgerPassWordMessageBox">請盡快聯繫主管單位</p>
                  <div class="forgerPassWordMessagetriangle"></div>
                </div>                
                <p class="forgerPassWord">忘記密碼?</p>
              </div>
              
            </div>
            
            <input type="password" v-model="password" id="password">
          </div>
        </div>
        
        <button type="submit">登入</button>
      </div>

      <div class="rightPart" >
        <img :src="LoginImage" class="parallax-image">
      </div>
      
    </form>
  </div>
</template>

<script>
import axios from 'axios';
import Cookies from 'js-cookie';

export default {
  data(){
    return{
      username:'',
      password:'',
      message:''
    };
  },
  computed:{
    LoginImage(){
      return `${this.$apiurl}/src/assets/basic/Mobile login.svg`
    }
  },
  methods:{
    login(){
      const formData = new FormData();
      formData.append('username', this.username);
      formData.append('password', this.password);
      axios.post(`${this.$apiurl}/api/Login.php`, formData)
      .then(response => {
        const data = response.data;
        if (data.success) {
          Cookies.set('sessionId', data.sessionId, { expires: 7 });
          this.$router.push('/BackStage');
        } else {
          this.message = data.message || 'Login failed';
        }
      })
      .catch(error => {
        if (error.response) {
          // 根據不同的 HTTP 狀態碼顯示不同的錯誤訊息
          if (error.response.status === 401) {
            this.message = '密碼錯誤，請重新嘗試';
          } else if (error.response.status === 404) {
            this.message = '帳號不存在，請確認您的帳號';
          } else if (error.response.status === 400) {
            this.message = '請輸入帳號和密碼';
          } else {
            this.message = '登入時發生錯誤，請檢察網路連線';
          }
        } else {
          // 當沒有收到伺服器的回應或其他錯誤時
          this.message = '無法連接伺服器，請稍後再試';
        }
      });
    },
    handleMouseMove(e) {
      const speed = 20; 
      const rightPart = this.$refs.rightPart; 
      const image = rightPart.querySelector('.parallax-image'); 
      const x = (rightPart.clientWidth / 2 - e.clientX) / speed;
      const y = (rightPart.clientHeight / 2 - e.clientY) / speed;
      image.style.transform = `translate(${x}px, ${y}px)`;
    }
  },
  mounted() {
    const rightPart = this.$refs.rightPart;
    rightPart.addEventListener('mousemove', this.handleMouseMove);
  },
  beforeDestroy() {
    const rightPart = this.$refs.rightPart;
    rightPart.removeEventListener('mousemove', this.handleMouseMove);
  }
}
</script>

<style scoped>
.AllPage{
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh;
  box-sizing: border-box;
}
button{
  width: 100%;
  font-size: 16px;
  text-align: center;
  padding: 10px;
  background-color: #5999ff;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor:pointer;
  transition: 0.2s;
}
button:hover{
  background-color: #116dff;
}
h1{
  display: inline;
}
label{
  display: flex;
  font-size: 18px;
  font-weight: 400;
  margin-bottom: 4px;
}
input{
  width: 100%;
  height: 30px;
}
.formPart{
  box-sizing: border-box;
  display: flex;
  align-items: center;
}
.leftPart{
  background-color: #fff;
  display: block;
  width: 500px;
  padding: 40px;
  box-sizing: border-box;
  border-radius: 10px;
  box-shadow:  2px 2px 8px 2px rgba(0, 0, 0, 0.1);
}
.userimputPart{
  padding: 20px 0 ;
}
.PasswprdTitle{
  display: flex;
  justify-content: space-between;
  align-items: center;  
}
.labelAndInput{
  padding: 8px 0;
}
.forgetDiv{
  display: flex;
  justify-content: center;
}
.forgerPassWord{
  font-size: 14px;
  line-height: 1;
  margin-bottom: 4px;
  cursor: pointer;
  position: relative;
}
.forgerPassWord:hover{
  border-bottom: 1px solid;
}
.forgerPassWordMessage{
  position: absolute;
  margin-top: -54px;
  display: none;
  flex-direction: column;
  align-items: center;
}
.forgetDiv:hover .forgerPassWordMessage{
  display: flex;
}
.forgerPassWordMessageBox{
  font-size: 14px;  
  color: #fff;
  background-color: #162d3d;
  padding: 4px 8px;
  border-radius: 6px;  
}
.forgerPassWordMessagetriangle{
  width: 0;
  height: 0;
  border-left: 8px solid transparent;
  border-right: 8px solid transparent;
  border-top: 8px solid #162d3d;
}
.rightPart {
  position: relative;
  overflow: hidden; /* 確保圖片不會移動到容器外部 */
}
.parallax-image {
  position: relative;
  transition: transform 0.1s ease-out;
  width: 600px;
  height: auto;
}
@media(max-width:1200px){
  .rightPart{
    display: none;
  }
}
</style>
