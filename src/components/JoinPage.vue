<template>
  <div>
    <MessageDiv/>
    <IsLoading v-show="isLoaind"/>
    
    <div v-show="!isLoaind" class="ObjectBoxFlex PaddingLeftRight">
      <h1>加入我們頁面 </h1>
      <button @click="submitJoinPage" type="submit" class="ItemButton">確定更新</button> 
    </div>
    
    <div v-show="!isLoaind" class="PaddingLeftRight PaddingBottom">
      <form @submit.prevent="submitJoinPage" enctype="multipart/form-data" class="formGrid">
        <table class="RouterPage">
          <tr class="ObjectBox ObjectBoxBoerderBottom">
            <h3 class="TitleH3">文章部分</h3>
          </tr>
          <div class="ObjectBox ObjectGrid">
            <tr class="ObjectItem">
              <td>標題</td>
              <td>
                <input type="text" v-model="Title" placeholder="這邊輸入標題" class="InputText">
              </td>
            </tr>

            <tr class="ObjectItem">
              <td>內文:</td>
              <td>
                <textarea v-model="Content" placeholder="這邊輸入內文" class="InputText"></textarea>
              </td>
            </tr>

            <tr class="ObjectItem">
              <td>按鈕文字</td>
              <td>
                <input type="text" v-model="btnText" placeholder="這邊輸入按鈕文字，建議四個字" class="InputText">
              </td>
            </tr>
          </div>
          </table>

          <table class="RouterPage">
            <tr class="ObjectBox ObjectBoxBoerderBottom">
              <h3 class="TitleH3">背景圖片</h3>
            </tr>
            <div class="ObjectBox ObjectGrid">
              <tr class="ObjectItem">
              <td>目前圖片</td>
              <td>
                <img v-if="current_image" :src="currentImageUrl" width="150px">
                <div v-else class="error">尚未上傳圖片</div>
              </td>
            </tr>
            
            <tr class="ObjectItem">
              <td>選擇圖片</td>
              <td>
                <input class="fileInput" type="file" @change="handleFileUpload">
                <button type="button" class="ItemButton" @click="triggerFileInput">選擇圖片</button>
                <div v-if="imageName" class="Font14">{{ imageName }}</div>
                <div v-else class="Font14">尚未更換圖片</div>
              </td>
            </tr>
            </div>          
        </table>
      </form>
    </div>
    
  </div>
</template>

<script>
import axios from 'axios';
import MessageDiv from './MessageDiv.vue';
import IsLoading from './IsLoading.vue';
export default {
  components:{
    MessageDiv,
    IsLoading
  },
  data() {
    return {
      Title:'',
      Content:'',
      btnText:'',
      current_image: '',
      image: null,
      imageName:'',
      isLoaind:true,
    }
  },
  computed: {
    currentImageUrl() {
      return `${this.$apiurl}/src/assets/join/${this.current_image}`;
    }
  },
  created() {
    this.fetchDetails();
  },
  methods:{
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
        }else{
          this.$bus.$emit('setErrorMessage', `${data.message}`);
        }
      })
      .catch(error =>{
        this.$bus.$emit('setErrorMessage', '資料庫連線錯誤');
        console.error(error);
      })
      this.isLoaind = false;
    },
    handleFileUpload(event) {
      this.image = event.target.files[0];
      this.imageName = this.image ?this.image.name : '';
    },
    triggerFileInput(){
      this.$el.querySelector('.fileInput').click();
    },
    submitJoinPage() {
      const formData = new FormData();
      formData.append('Title', this.Title);
      formData.append('Content', this.Content);
      formData.append('btnText', this.btnText);
      formData.append('current_image', this.current_image);
      if(this.image) {
        formData.append('image', this.image);
      }
      axios.post(`${this.$apiurl}/api/Add&UpdateJoinPage.php`,formData)
      .then(response=>{
        const data = response.data;
        if(data.success){
          this.$bus.$emit('setMessage', `${data.message}`);
          this.fetchDetails();
        }else{
          this.$bus.$emit('setErrorMessage', `${data.message}`);
        }
      })
      .catch(error => {
        this.$bus.$emit('setErrorMessage', `${error}`);
      });
    }
  }
}
</script>

<style>
</style>
