<template>
  <div>
    <MessageDiv
    :successMessage="successMessage"/>
    <IsLoading v-show="isLoaind"/>

    <div v-show="!isLoaind" class="ObjectBoxFlex PaddingLeftRight">
      <h1>關於我們</h1>
      <button @click="submitAbout" type="submit" class="ItemButton">確定更新</button> 
    </div>

    <div v-show="!isLoaind" class="PaddingLeftRight PaddingBottom">
      <form  @submit.prevent="submitAbout" enctype="multipart/form-data" class="formGrid">

        <AboutOne
        :title = "AboutOneTitle"
        @update:title = "AboutOneTitle = $event"
        :subTitle = "AboutOneSubTitle"
        @update:subTitle = "AboutOneSubTitle = $event"
        :currentImageOne = "currentImageOne"
        :image = "AboutOneBannerImage"
        @update:image = "AboutOneBannerImage = $event"
        :imageName = "AboutOneImageName"
        @update:imageName = "AboutOneImageName = $event"/>

        <AboutTwo
        :title = "AboutTwoTitle"
        @update:title = "AboutTwoTitle = $event"
        :writings = "AboutTwoWritings"
        @update:writings = "AboutTwoWritings = $event"
        :currentImage = "currentImageTwo"
        :image = "AboutTwoPersonrImage"
        @update:image = "AboutTwoPersonrImage = $event"
        :imageName = "AboutTwoImageName"
        @update:imageName = "AboutTwoImageName = $event"/>
        
        <AboutThreeBackImage
        :currentImageThreeBK = "currentImageThreeBK"
        :image = "AboutThreeBKImage"
        @update:image = "AboutThreeBKImage = $event"
        :imageName = "AboutThreeBKImageName"
        @update:imageName = "AboutThreeBKImageName = $event"/>

        <AboutThree/>
      </form>
    </div>
  </div> 
</template>

<script>
import axios from 'axios';
import MessageDiv from './MessageDiv.vue';
import IsLoading from './IsLoading.vue';
import AboutOne from './AboutOne.vue';
import AboutTwo from './AboutTwo.vue';
import AboutThree from './AboutThree.vue';
import AboutThreeBackImage from './AboutThreeBackImage.vue';

export default {
  components:{
    MessageDiv,
    IsLoading,
    AboutOne,
    AboutTwo,
    AboutThree,
    AboutThreeBackImage,
  },
  data(){
    return{
      isLoaind:true,
      AboutOneTitle:'',
      AboutOneSubTitle:'',
      currentImageOne: '',
      AboutOneBannerImage: null,
      AboutOneImageName:'',
      AboutTwoTitle:'',
      AboutTwoWritings:'',
      currentImageTwo:'',
      AboutTwoPersonrImage:null,
      AboutTwoImageName:'',
      currentImageThreeBK:'',
      AboutThreeBKImage:null,
      AboutThreeBKImageName:'',
    }
  },
  created() {
    this.fetchDetails();
    this.$bus.$on('setMessageToAbout', this.GetAboutAddMessage);
    this.successMessage = localStorage.getItem('successMessage') || ''; 
    localStorage.removeItem('successMessage');
  },
  beforeDestroy(){
  this.$bus.$off('setMessageToAbout', this.GetAboutAddMessage);
},
  methods: {
    setMessageToAbout(message){
      this.$bus.$emit('setMessage',message);
    },
    fetchDetails() {
      axios.get(`${this.$apiurl}/api/FetchAboutPage.php`)
      .then(response =>{
        const data = response.data;
        if(data.success){
          const about = data.about;
          this.AboutOneTitle = about.about_one_title;
          this.AboutOneSubTitle = about.about_one_subtitle;
          this.currentImageOne = about.about_one_image;
          this.AboutTwoTitle = about.about_two_title;
          this.AboutTwoWritings = about.about_two_writings;
          this.currentImageTwo = about.about_two_image;
          this.currentImageThreeBK = about.about_three_BK;
        }else{
          this.$bus.$emit('setErrorMessage', `${data.message}`);
        }
      })
      .catch(error => {
        this.$bus.$emit('setErrorMessage', '資料庫連線錯誤');
          console.error(error);
      });
      this.isLoaind = false;
    },
    submitAbout() {
      const formData = new FormData();
      formData.append('AboutOneTitle', this.AboutOneTitle);
      formData.append('AboutOneSubTitle', this.AboutOneSubTitle);
      formData.append('currentImageOne', this.currentImageOne);
      if (this.AboutOneBannerImage) {
        formData.append('AboutOneBannerImage', this.AboutOneBannerImage);
      }
      formData.append('AboutTwoTitle', this.AboutTwoTitle);
      formData.append('AboutTwoWritings', this.AboutTwoWritings);
      formData.append('currentImageTwo', this.currentImageTwo);
      if (this.AboutTwoPersonrImage) {
        formData.append('AboutTwoPersonrImage', this.AboutTwoPersonrImage);
      }
      if (this.AboutThreeBKImage) {
        formData.append('AboutThreeBKImage', this.AboutThreeBKImage);
      }
      axios.post(`${this.$apiurl}/api/Add&UpdateAboutPage.php`,formData)
      .then(response =>{
        const data = response.data;
        if(data.success){
          this. setMessageToAbout(`${data.message}`);
          this.fetchDetails(); 
        }else{
          this.$bus.$emit('setErrorMessage', `${data.message}`);
        }
      })
      .catch(error =>{
        this.$bus.$emit('setErrorMessage', `${error}`);
      })
    }
  }

}
</script>

<style>

</style>