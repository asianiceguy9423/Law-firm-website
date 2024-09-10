<template>
  <div>
    <MessageDiv/>
    <IsLoading v-show="isLoaind"/>

    <div
    v-show="!isLoaind"
    class="FlexBoxBottom PaddingLeftRight">
      <div>
        <div class="LinkButtonMarginLeft">
          <button @click="goBack" class="PointButton PointMargin" type="button">關於我們</button>
          <font-awesome-icon :icon="['fas', 'angle-right']" style="color: #acafc4;" class="PointMargin"/>
          <button class="PointButton" type="button">編輯人員</button>
        </div>
        <h1>更新人員資料</h1>
      </div>
      <div>
        <button @click="goBack" type="button" class="ItemButton ItemButtonWhite">取消</button>
        <button @click="submitAboutPageThree" type="submit" class="ItemButton">確定更新</button>
      </div>
    </div>
    <form
    v-show="!isLoaind"
    @submit.prevent="submitAboutPageThree" 
    enctype="multipart/form-data" 
    class="PaddingLeftRight">
      <table class="RouterPage">
        <tr class="ObjectBox ObjectBoxBoerderBottom">
          <h3 class="TitleH3">輸入事件</h3>
        </tr>
        <div class="ObjectBox ObjectGrid">
          <tr class="ObjectItem">
            <td>目前圖片</td>
            <td>
              <img v-if="current_image" :src="currentImageUrl" width="150px">
              <div v-else class="error">尚未上傳個人照片</div>
            </td>
          </tr>
          <tr class="ObjectItem">
            <td>選擇圖片</td>
            <td>
              <input
              class="fileInput" 
              type="file" 
              @change="handleFileUpload">
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
          <tr class="ObjectItem">
            <td>人名</td>
            <td>
              <input type="text" v-model="personName" placeholder="這邊輸入人名" class="InputText">
            </td>
          </tr>
          <tr class="ObjectItem">
            <td>職位</td>
            <td>
              <input type="text" v-model="position" placeholder="這邊輸入職位" class="InputText">
            </td>
          </tr>
          <tr class="ObjectItem">
            <td>專長</td>
            <textarea v-model="skill" placeholder="這邊輸入專長" class="InputText"></textarea>
          </tr>
          <tr class="ObjectItem">
            <td>專長</td>
            <textarea v-model="exp" placeholder="這邊書如經歷" class="InputText"></textarea>
          </tr>
        </div>        
      </table>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
import MessageDiv from './MessageDiv.vue';
import IsLoading from './IsLoading.vue';
export default {
  components:
  {MessageDiv,
    IsLoading
  },
  data() {
    return {
      id : this.$route.params.id, 
      personName:'',
      position:'',
      skill:'',
      exp:'',
      current_image: '',
      imageName:'',
      image: null,
      isLoaind:true,
      message: '', 
    }
  },
  computed: {
    currentImageUrl() {
      return `${this.$apiurl}/src/assets/about/${this.current_image}`;
    }
  },
  created() {
    this.fetchDetails();
  },
  methods:{
    fetchDetails(){
      axios.get(`${this.$apiurl}/api/UpdateAboutPageThree.php?id=${this.id}`)
      .then(response => {
        const data = response.data[0];
        if (data) {
            this.personName = data.personName;
            this.position = data.position;
            this.skill = data.skill;
            this.exp = data.exp;
            this.current_image = data.image_name;
          } else{
            this.$bus.$emit('setErrorMessage', `${data.message}`);
          }
      })
      .catch(error => {
        console.error(error);
      });
      this.isLoaind = false;
      window.scrollTo(0, 0);
    },
    handleFileUpload(event) {
      this.image = event.target.files[0];
      this.imageName = this.image ? this.image.name : '';
    },
    triggerFileInput(){
      this.$el.querySelector('.fileInput').click();
    },
    submitAboutPageThree() {
      const formData = new FormData();
      formData.append('id', this.id);
      formData.append('personName', this.personName);
      formData.append('position', this.position);
      formData.append('skill', this.skill);
      formData.append('exp', this.exp);
      formData.append('current_image', this.current_image);
      if(this.image) {
        formData.append('image', this.image);
      }
      fetch(`${this.$apiurl}/api/UpdateAboutPageThree.php`,{
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          localStorage.setItem('successMessage', `${data.message}`);
          this.$router.push('/BackStage/AboutPage');
          this.$bus.$emit('fetchAboutThree');
        } else {
          this.$bus.$emit('setErrorMessage', `${data.message}`);
        }
      })
      .catch(error => {
        this.$bus.$emit('setErrorMessage', `${error}`);
      });
    },
    goBack(){
      this.$router.go(-1);
    },
  }
}
</script>

<style>
</style>
