<template>
  <div>
    <MessageDiv/>

    <div class="FlexBoxBottom PaddingLeftRight">
      <div>
        <div class="LinkButtonMarginLeft">
          <button @click="goBack" class="PointButton PointMargin" type="button">首頁</button>
          <font-awesome-icon :icon="['fas', 'angle-right']" style="color: #acafc4;" class="PointMargin"/>
          <button class="PointButton" type="button">新增資訊</button>
        </div>
          <h1>增加事件</h1>
      </div>
      <div>
        <button @click="goBack" type="button" class="ItemButton ItemButtonWhite">取消</button>
        <button @click="submitHomePageTwo" type="submit" class="ItemButton">確定新增</button>
      </div>
    </div>

    <form
    @submit.prevent="submitHomePageTwo" 
    enctype="multipart/form-data" 
    class="PaddingLeftRight">
      <table class="RouterPage">
        <tr class="ObjectBox ObjectBoxBoerderBottom">
          <h3 class="TitleH3">輸入事件</h3>
        </tr>
        <div class="ObjectBox ObjectGrid">
          <tr class="ObjectItem">
            <td>事件名稱</td>
            <td>
              <input type="text" v-model="HomeTeoTitle" placeholder="輸入事件名稱" class="InputText">
            </td>
          </tr>
          <tr class="ObjectItem">
            <td>事件說明</td>
            <td>
              <textarea v-model="HomeTeoExp" placeholder="輸入事件名稱" class="InputText" required></textarea>
            </td>
          </tr>
          <tr class="ObjectItem">
            <td>選擇事件圖片</td>
            <td>
              <input
              class="fileInput" 
              type="file" 
              @change="HomeTwoPICUpload">
              <button 
              type="button" 
              class="ItemButton" 
              @click="triggerFileInput">
                選擇圖片
              </button>
              <div v-if="imageName" class="Font14">{{ imageName }}</div>
              <div v-else class="Font14">尚未更換圖片</div>
            </td>
          </tr>
        </div>
      </table>
    </form>
  </div>
</template>

<script>
import MessageDiv from './MessageDiv.vue';
import axios from 'axios';
export default {
  components:{
    MessageDiv,
  },
  data() {
    return {
      HomeTeoTitle:'',
      HomeTeoExp:'',
      image: null,
      imageName:'',
    }
  },
  methods:{
    HomeTwoPICUpload(event) {
      this.image = event.target.files[0];
      this.imageName = this.image ? this.image.name : '';
    },
    triggerFileInput(){
      this.$el.querySelector('.fileInput').click();
    },
    submitHomePageTwo() {
      const formData = new FormData();
      formData.append('HomeTeoTitle', this.HomeTeoTitle);
      formData.append('HomeTeoExp', this.HomeTeoExp);
      if(this.image) {
        formData.append('image', this.image);
      }
      axios.post(`${this.$apiurl}/api/AddHomePageTwo.php`,formData)
      .then(response=>{
        const data = response.data;
        if(data.success){
          localStorage.setItem('successMessage', `${data.message}`);
          this.$router.push('/BackStage/HomePage');
          this.$bus.$emit('fetchHomeTwo');
        }else{
          this.$bus.$emit('setErrorMessage', `${data.message}`);
        }
      })
      .catch(error => {
        this.$bus.$emit('setErrorMessage', `${error}`);
      });
      window.scrollTo(0, 0);
    },
    goBack(){
      this.$router.go(-1);
    },
  }
}
</script>

<style>
</style>
