<template>
  <div>
    <MessageDiv
    />
    <IsLoading v-show="isLoad"/>

    <div v-show="!isLoad" class="ObjectBoxFlex PaddingLeftRight">
      <h1>店家基本資訊</h1>
      <button @click="submitPage" type="submit" class="ItemButton">確定更新</button>
    </div>

    <div v-show="!isLoad" class="PaddingLeftRight PaddingBottom">
      <form
        @submit.prevent="submitHomePage"
        enctype="multipart/form-data"
        class="formGrid">

        <BasicInformationLogo
        :currentLOGO = "currentLOGO"
        :image = "LOGOImage"
        @update:image = "LOGOImage = $event"
        :imageName = "LOGOImageName"
        @update:imageName = "LOGOImageName = $event"/>

        <BasicFooterInformation
        :yourPhonenumber="yourPhonenumber"
        @update:yourPhonenumber = "yourPhonenumber = $event"
        :yourMail="yourMail"
        @update:yourMail = "yourMail = $event"
        :yourAddress="yourAddress"
        @update:yourAddress = "yourAddress = $event"
        :yourTime="yourTime"
        @update:yourTime = "yourTime = $event"
        :selectedOptions="selectedOptions"
        @update:selectedOptions = "selectedOptions = $event"/>

        <BasicFooterLink
        :yourFacebook="yourFacebook"
        @update:yourFacebook = "yourFacebook = $event"
        :yourInstagram="yourInstagram"
        @update:yourInstagram = "yourInstagram = $event"
        :yourLine="yourLine"
        @update:yourLine = "yourLine = $event"
        :yourYoutube="yourYoutube"
        @update:yourYoutube = "yourYoutube = $event"
        :selectedLinkOptions="selectedLinkOptions"
        @update:selectedLinkOptions = "selectedLinkOptions = $event"/>      
       
      </form>
    </div>
  </div>
</template>

<script>
import BasicInformationLogo from './BasicInformationLogo.vue';
import BasicFooterInformation from './BasicFooterInformation.vue';
import BasicFooterLink from './BasicFooterLink.vue';
import MessageDiv from './MessageDiv.vue';
import IsLoading from './IsLoading.vue';
import axios from 'axios';

export default {
  components:{
    MessageDiv,
    BasicInformationLogo,
    IsLoading,
    BasicFooterInformation,
    BasicFooterLink
  },
  data() {
    return {
      YourLOGO:'',
      currentLOGO: '',
      LOGOImage: null,
      LOGOImageName:'',
      yourPhonenumber:'',
      yourMail:'',
      yourAddress:'',
      yourTime:'',
      selectedOptions:[],
      yourFacebook:'',
      yourInstagram:'',
      yourLine:'',
      yourYoutube:'',
      selectedLinkOptions:[],
      
      isLoad:true,
    };
  },
  created() {
  this.fetchDetails();
  },
  methods: {
    GetSuccessAddMessage(message){
      this.$bus.$emit('setMessage',message);
    },
    fetchDetails() {
      axios.get(`${this.$apiurl}/api/FetchBasicPage.php`)
        .then(response => {
          const data = response.data;
          if (data.success) {
            const basic = data.basic;
            this.currentLOGO = basic.basic_logo;
            this.yourPhonenumber = basic.basic_phonenumber;
            this.yourMail = basic.basic_mail;
            this.yourAddress = basic.basic_address;
            this.yourTime = basic.basic_time;
            this.selectedOptions = Array.isArray(basic.basic_selected_options) ? basic.basic_selected_options : [];
            this.yourFacebook = basic.basic_facebook;
            this.yourInstagram = basic.basic_instagram;
            this.yourLine = basic.basic_line;
            this.yourYoutube = basic.basic_youtube;
            this.selectedLinkOptions = Array.isArray(basic.basic_selected_link_options) ? basic.basic_selected_link_options : [];
          } else {
            this.$bus.$emit('setErrorMessage', `${data.message}`);
          }
        })
        .catch(error => {
          this.$bus.$emit('setErrorMessage', '資料庫連線錯誤');
          console.error(error);
        })
        .finally(() => {
          this.isLoad = false;
        });
    },
    submitPage() {
      const formData = new FormData();
      formData.append('currentLOGO', this.currentLOGO);
      if (this.LOGOImage) {
        formData.append('LOGOImage', this.LOGOImage);
      }
      formData.append('yourPhonenumber', this.yourPhonenumber);
      formData.append('yourMail', this.yourMail);
      formData.append('yourAddress', this.yourAddress);
      formData.append('yourTime', this.yourTime);
      formData.append('selectedOptions', JSON.stringify(this.selectedOptions));
      formData.append('yourFacebook', this.yourFacebook);
      formData.append('yourInstagram', this.yourInstagram);
      formData.append('yourLine', this.yourLine);
      formData.append('yourYoutube', this.yourYoutube);
      formData.append('selectedLinkOptions', JSON.stringify(this.selectedLinkOptions));
      axios.post(`${this.$apiurl}/api/Add&UpdateBasicPage.php`, formData)
        .then(response => {
          const data = response.data;
          if (data.success) {
            this.GetSuccessAddMessage(`${data.message}`);
            this.fetchDetails();
          } else {
            this.$bus.$emit('setErrorMessage', `${data.message}`);
            console.log('666')
          }
        })
        .catch(error => {
          this.$bus.$emit('setErrorMessage', `${error.message}`);
        });
    },

  },
};
</script>

<style >
.labelDiv {
  display: flex;
  gap: 10px;
  align-items: center;
}
.basicObject {
  white-space: nowrap;
  width: 100px;
}
</style>
