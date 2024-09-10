<template>
  <div>
    <MessageDiv
    :successMessage="successMessage"/>
    <IsLoading v-show="isLoaind"/>

    <div v-show="!isLoaind" class="ObjectBoxFlex PaddingLeftRight">
      <h1>文章頁面 </h1>
      <button @click="submitLawBanner" type="submit" class="ItemButton">確定更新</button>
    </div>
    
    <div v-show="!isLoaind"
    class="PaddingLeftRight PaddingBottom">
      <form class="formGrid"
      @submit.prevent="submitLawBanner"
      enctype="multipart/form-data">

        <LawBannerPatent
        :title            = "PatentTitle"
        @update:title     = "PatentTitle = $event"
        :image            = "PatentImage"
        @update:image     = "PatentImage = $event"
        :currentimage     = "currentPatentImage"
        :imageName        = "PatentImageName"
        @update:imageName = "PatentImageName = $event"/>

        <LawBannerTraffic
        :title            = "TrafficTitle"
        @update:title     = "TrafficTitle = $event"
        :image            = "TrafficImage"
        @update:image     = "TrafficImage = $event"
        :currentimage     = "currentTrafficImage"
        :imageName        = "TrafficImageName"
        @update:imageName = "TrafficImageName = $event"/>

        <LawBannerLabor
        :title            = "LaborTitle"
        @update:title     = "LaborTitle = $event"
        :image            = "LaborImage"
        @update:image     = "LaborImage = $event"
        :currentimage     = "currentLaborImage"
        :imageName        = "LaborImageName"
        @update:imageName = "LaborImageName = $event"/>

        <LawBannerCivil
        :title            = "CivilTitle"
        @update:title     = "CivilTitle = $event"
        :image            = "CivilImage"
        @update:image     = "CivilImage = $event"
        :currentimage     = "currentCivilImage"
        :imageName        = "CivilImageName"
        @update:imageName = "CivilImageName = $event"/>

        <LawBannerCriminal
        :title            = "CriminalTitle"
        @update:title     = "CriminalTitle = $event"
        :image            = "CriminalImage"
        @update:image     = "CriminalImage = $event"
        :currentimage     = "currentCriminalImage"
        :imageName        = "CriminalImageName"
        @update:imageName = "CriminalImageName = $event"/>

        <LawImprint/>
        <LawFutureWritings
        :title                    = "FutureTitle"
        @update:title             = "FutureTitle = $event"
        :text                     = "FutureText"
        @update:text              = "FutureText = $event"
        :image                    = "FutureImage"
        @update:image             = "FutureImage = $event"
        :currentimage             = "currentFutureImage"
        :imageName                = "FutureImageName"
        @update:imageName         = "FutureImageName = $event"
        :displayWritings          = "displayWritings"
        @update:displayWritings   = "displayWritings = $event"/>        
      </form>
    </div>    
  </div>
</template>

<script>
import axios from 'axios';
import MessageDiv from './MessageDiv.vue';
import IsLoading from './IsLoading.vue';
import LawImprint from './LawImprint.vue';
import LawBannerPatent from './LawBannerPatent.vue';
import LawBannerTraffic from './LawBannerTraffic.vue';
import LawBannerLabor from './LawBannerLabor .vue';
import LawBannerCivil from './LawBannerCivil.vue';
import LawBannerCriminal from './LawBannerCriminal.vue';
import LawFutureWritings from './LawFutureWritings.vue';

export default {
  components:{
    MessageDiv,
    IsLoading,
    LawImprint,
    LawBannerPatent,
    LawBannerTraffic,
    LawBannerLabor,
    LawBannerCivil,
    LawBannerCriminal,
    LawFutureWritings
  },
  data() {
    return {
      PatentTitle:'',
      currentPatentImage: '',
      PatentImage: null,
      PatentImageName:'',

      TrafficTitle:'',
      currentTrafficImage: '',
      TrafficImage: null,
      TrafficImageName:'',

      LaborTitle:'',
      currentLaborImage: '',
      LaborImage: null,
      LaborImageName:'',

      CivilTitle:'',
      currentCivilImage: '',
      CivilImage: null,
      CivilImageName:'',

      CriminalTitle:'',
      currentCriminalImage: '',
      CriminalImage: null,
      CriminalImageName:'',

      FutureTitle:'',
      FutureText:'',
      FutureImage: null,
      currentFutureImage:'',
      FutureImageName:'',
      displayWritings: false,

      isLoaind:false,
    }
  },
  created() {
    this.fetchDetails();
    this.$bus.$on('setMessageToLaw', this.GetLawAddMessage);
    this.successMessage = localStorage.getItem('successMessage') || ''; 
    localStorage.removeItem('successMessage');
  },
  beforeDestroy(){
    this.$bus.$off('setMessageToLaw', this.GetLawAddMessage);
  },
  methods: {
    GetLawAddMessage(message){
      this.$bus.$emit('setMessage',message);
    },
    updateDisplayWritings(){
      this.displayWritings = event.target.checked;
      
    },
    fetchDetails() {
      axios.get(`${this.$apiurl}/api/FetchLawBannerPage.php`)
        .then(response => {
          const data = response.data;
          if (data.success) {
            const law = data.law;
            this.PatentTitle = law.law_patent_title;
            this.currentPatentImage = law.law_patent_image;
            this.TrafficTitle = law.law_traffic_title;
            this.currentTrafficImage = law.law_traffic_image;
            this.LaborTitle = law.law_labor_title;
            this.currentLaborImage = law.law_labor_image;
            this.CivilTitle = law.law_civil_title;
            this.currentCivilImage = law.law_civil_image;
            this.CriminalTitle = law.law_criminal_title;
            this.currentCriminalImage = law.law_criminal_image;
            this.FutureTitle = law.law_future_title;
            this.FutureText = law.law_future_text;
            this.currentFutureImage = law.law_future_image;
            this.displayWritings = law.law_future_display == 1 ? true : false;
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
    submitLawBanner() {
      const formData = new FormData();
      formData.append('PatentTitle', this.PatentTitle);
      formData.append('currentPatentImage', this.currentPatentImage);
      if(this.PatentImage) {
        formData.append('PatentImage', this.PatentImage);
      }
      formData.append('TrafficTitle', this.TrafficTitle);
      formData.append('currentTrafficImage', this.currentTrafficImage);
      if(this.TrafficImage) {
        formData.append('TrafficImage', this.TrafficImage);
      }
      formData.append('LaborTitle', this.LaborTitle);
      formData.append('currentLaborImage', this.currentLaborImage);
      if(this.LaborImage) {
        formData.append('LaborImage', this.LaborImage);
      }
      formData.append('CivilTitle', this.CivilTitle);
      formData.append('currentCivilImage', this.currentCivilImage);
      if(this.CivilImage) {
        formData.append('CivilImage', this.CivilImage);
      }
      formData.append('CriminalTitle', this.CriminalTitle);
      formData.append('currentCriminalImage', this.currentCriminalImage);
      if(this.CriminalImage) {
        formData.append('CriminalImage', this.CriminalImage);
      }
      formData.append('FutureTitle', this.FutureTitle);
      formData.append('FutureText', this.FutureText);
      formData.append('currentFutureImage', this.currentFutureImage);
      formData.append('displayWritings', this.displayWritings ? 1 : 0);
      if(this.FutureImage) {
        formData.append('FutureImage', this.FutureImage);
      }
      axios.post(`${this.$apiurl}/api/Add&UpdateLawBannerPage.php`,formData)
      .then(response=>{
        const data = response.data;
        if(data.success){
          this. GetLawAddMessage(`${data.message}`);
          this.fetchDetails();
        }else{
          this.$bus.$emit('setErrorMessage', `${data.message}`);
        }
      })
      .catch(error => {
        this.$bus.$emit('setErrorMessage', `${error}`);
      });
    },
  }
}
</script>

<style>
</style>
