<template>
  <div class="footer">
    
    <FrontFooterInformation
    :currentLOGO = "currentLOGO"
    :yourPhonenumber = "yourPhonenumber"
    :yourMail ="yourMail"
    :yourAddress = "yourAddress"
    :yourTime = "yourTime"
    :selectedOptions = "selectedOptions"/>

    <FrontFooterWritingLink/>

    <FrontFooterLink
    :yourFacebook = "yourFacebook"
    :yourInstagram = "yourInstagram"
    :yourLine = "yourLine"
    :yourYoutube = "yourYoutube"
    :selectedLinkOptions = "selectedLinkOptions"/>
  </div>
</template>

<script>
import axios from 'axios';
import FrontFooterInformation from './FrontFooterInformation.vue';
import FrontFooterLink from './FrontFooterLink.vue';
import FrontFooterWritingLink from './FrontFooterWritingLink.vue';

export default {
  components:{
    FrontFooterInformation,
    FrontFooterLink,
    FrontFooterWritingLink,
  },
  data(){
    return{
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
    }
  },
  created() {
  this.fetchDetails();
  },
  methods:{
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
          }
        })
        .catch(error => {
          console.error(error.message);
        })
    },
  }
}
</script>

<style scoped>
h3{
  font-size: 20px;
}
/deep/ li{
  font-size: 16px;
}
.footer{
  width: 100%;
  background-color: rgb(71, 71, 71);
  color: #fff;
  display: flex;
  justify-content: space-between;
  box-sizing: border-box;
  padding: 70px 100px;
}
/deep/ .LiDiv{
  display: flex;
  flex-direction: column;
  row-gap: 5px;
  padding: 8px 0;
}
@media(max-width: 1000px){
  /deep/ li{
    font-size: 20px;
  }
  h3{
    font-size: 30px;
  }
  .footer{
    flex-direction: column;
    justify-content: center;
    text-align: center;
    padding: 50px 30px;
  }
  /deep/ .left,.middle,.right{
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 15px;
  }

}


</style>