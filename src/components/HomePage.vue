<template>
  <div>
    <MessageDiv
    :successMessage="successMessage"/>
    <IsLoading v-show="isLoaind"/>

    <div v-show="!isLoaind" class="ObjectBoxFlex PaddingLeftRight">
      <h1>首頁 </h1>
      <button @click="submitHomePage" type="submit" class="ItemButton">確定更新</button>
    </div>

    <div v-show="!isLoaind" class="PaddingLeftRight PaddingBottom">
      <form
        @submit.prevent="submitHomePage"
        enctype="multipart/form-data"
        class="formGrid">
        
        <HomePageOne
        :title = "HomeOneTitle"
        @update:title = "HomeOneTitle = $event"
        :btn = "HomeOneBtn"
        @update:btn = "HomeOneBtn = $event"
        :image = "HomeBannerimage"        
        @update:image= "HomeBannerimage = $event"
        :currentimage="currentHomeOne_image"
        :imageName = "HomeBannerImageName"
        @update:imageName = "HomeBannerImageName = $event"/>

        <HomePageTwoTitle
        :title = "HomeTwoTitle"
        @update:title = "HomeTwoTitle = $event"/>

        <HomePageTwo/>

        <HomePageThree
        :currentImage = "currentHomeThree_image"
        :image = "HomeThreeIimage"
        @update:image = "HomeThreeIimage = $event"
        :imageName = "HomeThreeImageName"
        @update:imageName = " HomeThreeImageName = $event"
        :title = "HomeThreeTitle"
        @update:title = "HomeThreeTitle = $event"
        :content = "HomeThreeContent"
        @update:content = "HomeThreeContent = $event"
        :btn = "HomeThreeBtn"
        @update:btn = "HomeThreeBtn = $event"/>
      </form>
    </div>
  </div>
</template>

<script>
import HomePageOne from './HomePageOne.vue';
import HomePageTwoTitle from './HomePageTwoTitle.vue';
import HomePageTwo from './HomePageTwo.vue';
import HomePageThree from './HomePageThree.vue';
import MessageDiv from './MessageDiv.vue';
import IsLoading from './IsLoading.vue';
import axios from 'axios';

export default {
  components:{
    MessageDiv,
    HomePageOne,
    HomePageTwo,
    HomePageTwoTitle,
    HomePageThree,
    IsLoading
  },
  data() {
    return {
      HomeOneTitle:'',
      HomeOneBtn:'',
      currentHomeOne_image: '',
      HomeBannerimage: null,
      HomeBannerImageName:'',
      HomeTwoTitle:'',
      HomeThreeTitle:'',
      HomeThreeContent:'',
      HomeThreeBtn:'',
      currentHomeThree_image: '',
      HomeThreeImageName:'',
      HomeThreeIimage: null,
      isLoaind:true,
    };
  },
  created() {
  this.fetchDetails();
  this.$bus.$on('setMessageToHome', this.GetHomeAddMessage);
  this.successMessage = localStorage.getItem('successMessage') || ''; 
  localStorage.removeItem('successMessage');
},
beforeDestroy(){
  this.$bus.$off('setMessageToHome', this.GetHomeAddMessage);
},
  methods: {
    GetHomeAddMessage(message){
      this.$bus.$emit('setMessage',message);
    },
    fetchDetails() {
      axios.get(`${this.$apiurl}/api/FetchHomePage.php`)
        .then(response => {
          const data = response.data;
          if (data.success) {
            const home = data.home;
            this.HomeOneTitle = home.home_one_title;
            this.HomeOneBtn = home.home_one_btn;
            this.currentHomeOne_image = home.home_one_image;
            this.HomeTwoTitle = home.home_two_title;
            this.HomeThreeTitle = home.home_three_title;
            this.HomeThreeContent = home.home_three_content;
            this.HomeThreeBtn = home.home_three_btn;
            this.currentHomeThree_image = home.home_three_image;
        } else {
          this.$bus.$emit('setErrorMessage', `${data.message}`);
        }
      })
      .catch(error => {
        this.$bus.$emit('setErrorMessage', '資料庫連線錯誤');
          console.error(error.message);
      });
      this.isLoaind = false;
    },
    submitHomePage() {
      const formData = new FormData();
      formData.append('HomeOneTitle', this.HomeOneTitle);
      formData.append('HomeOneBtn', this.HomeOneBtn);
      formData.append('currentHomeOne_image', this.currentHomeOne_image);
      if(this.HomeBannerimage) {
        formData.append('HomeBannerimage', this.HomeBannerimage);
      }
      formData.append('HomeTwoTitle', this.HomeTwoTitle);
      formData.append('HomeThreeTitle', this.HomeThreeTitle);
      formData.append('HomeThreeContent', this.HomeThreeContent);
      formData.append('HomeThreeBtn', this.HomeThreeBtn);
      formData.append('currentHomeThree_image', this.currentHomeThree_image);
      if(this.HomeThreeIimage) {
        formData.append('HomeThreeIimage', this.HomeThreeIimage);
      }
      axios.post(`${this.$apiurl}/api/Add&UpdateHomePage.php`,formData)
      .then(response=>{
        const data = response.data;
        if(data.success){
          this. GetHomeAddMessage(`${data.message}`);
          this.fetchDetails();
        }else{
          this.$bus.$emit('setErrorMessage', `${data.message}`);
        }
      })
      .catch(error => {
        this.$bus.$emit('setErrorMessage', `${error}`);
      });
    },
  },
};
</script>
