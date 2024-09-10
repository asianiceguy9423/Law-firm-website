<template>
  <div>
    <MessageDiv/>
    <IsLoading v-show="isLoaind"/>    
    
    <div v-show="!isLoaind" class="FlexBoxBottom PaddingLeftRight">
      <div>
        <div class="LinkButtonMarginLeft">
          <button @click="goBack" class="PointButton PointMargin" type="button">聯絡我們</button>
          <font-awesome-icon :icon="['fas', 'angle-right']" style="color: #acafc4;" class="PointMargin"/>
          <button class="PointButton" type="button">新增資訊</button>
        </div>
        <h1>更改文章</h1>
      </div>
      <div>
        <button @click="goBack" type="button" class="ItemButton ItemButtonWhite">取消</button>
        <button @click="UpdateLawWriting" type="submit" class="ItemButton">確定新增</button>
      </div>
    </div>
    
    <form v-show="!isLoaind" @submit.prevent="UpdateLawWriting" enctype="multipart/form-data" class="PaddingLeftRight">
      <table class="RouterPage">
        <tr class="ObjectBox ObjectBoxBoerderBottom">
          <h3 class="TitleH3">文章內容</h3>
        </tr>
        <div class="ObjectBox ObjectGrid">
          <tr class="ObjectItem">
            <td>文章名稱</td>
            <td>
              <input type="text" v-model="LawTitle" placeholder="輸入文章標題" class="InputText">
            </td>
          </tr>

          <tr class="ObjectItem">
          <td>文章類型</td>
          <td>
            <button 
              class="ItemButton Lawbutton" 
              :class="{'ActiveLawBtn' : LawClass.includes('智產')}" 
              @click="LawClassClick('智產')" 
              type="button">智慧財產權
            </button>
            <button 
              class="ItemButton Lawbutton" 
              :class="{'ActiveLawBtn' : LawClass.includes('車禍')}" 
              @click="LawClassClick('車禍')" 
              type="button">
              車禍
            </button>
            <button 
              class="ItemButton Lawbutton" 
              :class="{'ActiveLawBtn' : LawClass.includes('勞基')}" 
              @click="LawClassClick('勞基')" 
              type="button">
              勞資糾紛
            </button>
            <button 
              class="ItemButton Lawbutton" 
              :class="{'ActiveLawBtn' : LawClass.includes('民事')}" 
              @click="LawClassClick('民事')" 
              type="button">
              民事案件
            </button>
            <button 
              class="ItemButton Lawbutton" 
              :class="{'ActiveLawBtn' : LawClass.includes('刑事')}" 
              @click="LawClassClick('刑事')" 
              type="button">
              刑事及毒品
            </button>
          </td>
        </tr>

        <tr class="ObjectItem">
          <td>目前Banner圖片</td>
          <td>
            <img v-if="current_banner" :src="currentBannerUrl" width="150px">
            <div v-else class="error">尚未上傳banner照片</div>
          </td>
        </tr>
        <tr class="ObjectItem">
          <td>選擇Banner圖片</td>
          <td>
            <input
            class="fileInput fileInputBanner" 
            type="file" 
            @change="LawBannerImageUpload">
              <button 
                type="button" 
                class="ItemButton" 
                @click="triggerBannerFileInput">
                選擇圖片
              </button>
              <div v-if="BannerImageName" class="Font14">{{ BannerImageName }}</div>
              <div v-else class="Font14">尚未更換圖片</div>
          </td>
        </tr>

        <tr class="ObjectItem">
          <td>目前文章圖片</td>
          <td>
            <img v-if="current_big_image" :src="currentBigImageUrl" width="150px">
            <div v-else class="error">尚未上傳文章照片</div>
          </td>
        </tr>
        <tr class="ObjectItem">
          <td>選擇文章圖片</td>
          <td>
            <input
              class="fileInput fileInputBigImage" 
              type="file" 
              @change="LawBigImageUpload">
            <button 
              type="button" 
              class="ItemButton" 
              @click="triggerBigFileInput">
              選擇圖片
            </button>
            <div v-if="BigimageName" class="Font14">{{ BigimageName }}</div>
            <div v-else class="Font14">尚未更換圖片</div>
          </td>
        </tr>

        <tr class="ObjectItem">
          <td>文章介紹</td>
          <td>
            <textarea v-model="LawTextPoint" placeholder="輸入文章介紹" class="InputText"></textarea>
          </td>
        </tr> 

        <tr class="ObjectItem">
          <td>文章內容(以html形式):</td>
          <td>
            <textarea v-model="LawText" placeholder="輸入內容" class="InputText"></textarea>
          </td>
        </tr> 
        </div>
      </table>
    </form>
  </div>
</template>

<script>
import IsLoading from './IsLoading.vue';
import axios from 'axios';
import MessageDiv from './MessageDiv.vue';
export default {
  components:{
    IsLoading,
    MessageDiv
  },
  data() {
    return {
      id : this.$route.params.id,
      LawTitle:'',
      LawClass:[],
      LawText: '',
      LawTextPoint:'',
      current_banner:'',
      current_big_image:'',
      LawBannerImage: null,
      LawBigImage: null,
      BannerImageName:'',
      BigimageName:'',
      isLoaind:true,
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
            this.LawTextPoint = data.text_point;
            this.current_banner  = data.banner_image;
            this.current_big_image  = data.big_image;
          } else{
            this.$bus.$emit('setErrorMessage', `${data.message}`);
          }
      })
      .catch(error => {
        this.$bus.$emit('setErrorMessage', '資料庫連線錯誤');
        console.error(error.message);
      });
      this.isLoaind = false;
      window.scrollTo(0, 0);
    },
    LawClassClick(event){
      if(this.LawClass.includes(event)){
        this.LawClass = this.LawClass.filter(item =>item !== event);
      }else{
        this.LawClass.push(event);
      }
      // console.log('LawClass:', ...this.LawClass); //<--debug用 別刪
    },
    LawBannerImageUpload(event){
      this.LawBannerImage = event.target.files[0];
      this.BannerImageName = this.LawBannerImage ?this.LawBannerImage.name : '';
    },
    triggerBannerFileInput(){
      this.$el.querySelector('.fileInputBanner').click();
    },
    LawBigImageUpload(event){
      this.LawBigImage = event.target.files[0];
      this.BigimageName = this.LawBigImage ?this.LawBigImage.name : '';
    },
    triggerBigFileInput(){
      this.$el.querySelector('.fileInputBigImage').click();
    },
    UpdateLawWriting(){
      const formData = new FormData();
      formData.append('id', this.id);
      formData.append('LawTitle', this.LawTitle);
      formData.append('LawClass', this.LawClass.join(','));
      formData.append('LawText', this.LawText);
      formData.append('LawTextPoint', this.LawTextPoint);
      formData.append('current_banner', this.current_banner);
      formData.append('current_big_image', this.current_big_image);
      if(this.LawBannerImage){
        formData.append('LawBannerImage', this.LawBannerImage);
      }
      if(this.LawBigImage){
        formData.append('LawBigImage', this.LawBigImage);
      }
      axios.post(`${this.$apiurl}/api/UpdateLawWriting.php?id=${this.id}`,formData)
      .then(response => {
        const data = response.data;
        if(data.success){
          localStorage.setItem('successMessage', `${data.message}`);
          this.$router.push('/BackStage/LawPage');
          this.$bus.$emit('fetchLaw');
        }else{
          this.$bus.$emit('setErrorMessage', `${data.message}`);
        }
      })
      .catch(error =>{
        this.$bus.$emit('setErrorMessage', `${error}`);
      })
      window.scrollTo(0, 0);
    },
    goBack() {
      this.$router.go(-1);
    }
  } 
}
</script>

<style scoped>
.ActiveLawBtn{
  background-color: #162d3d;
  color: #ffff;
  transition: background-color 0.2s;
}
.ActiveLawBtn:hover{
  background-color: #5f6375;
}
</style>
