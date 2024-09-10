<template>
  <div>
    <MessageDiv/>

    <div class="FlexBoxBottom PaddingLeftRight">
      <div>
        <div class="LinkButtonMarginLeft">
          <button @click="goBack" class="PointButton PointMargin" type="button">關於我們</button>
          <font-awesome-icon :icon="['fas', 'angle-right']" style="color: #acafc4;" class="PointMargin"/>
          <button class="PointButton" type="button">新增人員</button>
        </div>
        <h1>增加事件</h1>
      </div>
      <div>
        <button @click="goBack" type="button" class="ItemButton ItemButtonWhite">取消</button>
        <button @click="submitAboutPageThree" type="submit" class="ItemButton">確定新增</button>
      </div>
    </div>

    <form @submit.prevent="submitAboutPageThree" enctype="multipart/form-data" class="PaddingLeftRight">
      <table class="RouterPage">
        <tr class="ObjectBox ObjectBoxBoerderBottom">
          <h3 class="TitleH3">輸入事件</h3>
        </tr>
        <div class="ObjectBox ObjectGrid">
          <tr class="ObjectItem">
            <td>個人圖片</td>
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
            <td>經歷</td>
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
export default {
  components:{
    MessageDiv
  },
  data() {
    return {
      personName:'',
      position:'',
      skill:'',
      exp:'',
      image: null,
      imageName:'',
    }
  },
  created(){
    window.scrollTo(0, 0);
  },
  methods:{
    handleFileUpload(event) {
      this.image = event.target.files[0];
      this.imageName = this.image ? this.image.name : '';
    },
    triggerFileInput(){
      this.$el.querySelector('.fileInput').click();
    },
    submitAboutPageThree() {
      const formData = new FormData();
      formData.append('personName', this.personName);
      formData.append('position', this.position);
      formData.append('skill', this.skill);
      formData.append('exp', this.exp);
      if(this.image) {
        formData.append('image', this.image);
      }
      axios.post(`${this.$apiurl}/api/AddAboutPageThreePerson.php`,formData)
      .then(response => {
        const data = response.data;
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
        console.log('error')
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
