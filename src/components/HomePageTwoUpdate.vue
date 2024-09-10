<template>
  <div>
    <MessageDiv/>
    <IsLoading v-show="isLoaind"/>

    <div v-show="!isLoaind" class="FlexBoxBottom PaddingLeftRight">
      <div>
        <div class="LinkButtonMarginLeft">
          <button @click="goBack" class="PointButton PointMargin" type="button">首頁</button>
          <font-awesome-icon :icon="['fas', 'angle-right']" style="color: #acafc4;" class="PointMargin"/>
          <button class="PointButton" type="button">更新資訊</button>
        </div>
        <h1>更新事件 </h1>
      </div>
      <div>
        <button @click="goBack" type="button" class="ItemButton ItemButtonWhite">取消</button>
        <button @click="submitHomePageTwo" type="submit" class="ItemButton">確定更新</button>
      </div>
    </div>

    <form 
    v-show="!isLoaind"
    @submit.prevent="submitHomePageTwo" 
    enctype="multipart/form-data"
    class="PaddingLeftRight">
      <table class="RouterPage">
        <tr class="ObjectBox ObjectBoxBoerderBottom">
          <h3 class="TitleH3">更新事件</h3>
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
            <td>目前事件圖片</td>
            <td>
              <img v-if="currentHomeTwo_image" :src="currentHomeTwoPICImageUrl" width="150px">
              <div v-else class="error">尚未上傳圖片</div>
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
import IsLoading from './IsLoading.vue';
import axios from 'axios';
export default {
  components:{
    MessageDiv,IsLoading
  },
  data() {
    return {
      id : this.$route.params.id,
      HomeTeoTitle:'',
      HomeTeoExp:'',
      currentHomeTwo_image: '',
      image: null,
      imageName:'',
      isLoaind:true,
    }
  },
  computed: {
    currentHomeTwoPICImageUrl() {
      return `${this.$apiurl}/src/assets/home/${this.currentHomeTwo_image}`;
    }
  },
  created() {
    this.fetchDetails();
  },
  methods:{
    fetchDetails(){
      axios.get(`${this.$apiurl}/api/UpdateHomePageTwo.php?id=${this.id}`)
      .then(response => {
        const data = response.data[0];
        if (data) {
            this.HomeTeoTitle = data.home_two_title;
            this.HomeTeoExp = data.home_two_exp;
            this.currentHomeTwo_image = data.home_two_image;
          } else{
            this.$bus.$emit('setErrorMessage', `${data.message}`);
          }
      })
      .catch(error => {
        this.$bus.$emit('setErrorMessage', `${error}`);
        console.error(error);
      });
      this.isLoaind = false;
      window.scrollTo(0, 0);
    },
    HomeTwoPICUpload(event) {
      this.image = event.target.files[0];
      this.imageName = this.image ? this.image.name : '';
    },
    triggerFileInput(){
      this.$el.querySelector('.fileInput').click();
    },
    submitHomePageTwo() {
      const formData = new FormData();
      formData.append('id', this.id);
      formData.append('HomeTeoTitle', this.HomeTeoTitle);
      formData.append('HomeTeoExp', this.HomeTeoExp);
      formData.append('currentHomeTwo_image', this.currentHomeTwo_image);
      if(this.image) {
        formData.append('image', this.image);
      }
      axios.post(`${this.$apiurl}/api/UpdateHomePageTwo.php`,formData)
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
