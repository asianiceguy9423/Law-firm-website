<template>
  <div>
    <MessageDiv
    :successMessage="successMessage"/>
    
    <div class="ObjectBoxFlex PaddingLeftRight">
      <h1>聯絡我們頁面 </h1>
      <button @click="submitContactPage" type="submit" class="ItemButton">確定更新</button>  
    </div>
    
    <div class="PaddingLeftRight PaddingBottom">
      <form @submit.prevent="submitContactPage" enctype="multipart/form-data" class="formGrid"> 

      <ContactPageOne
      :title = "BannerTitle"
      @update:title = "BannerTitle = $event"
      :current_image = "current_image"
      :image = "image"
      @update:image = "image = $event"
      :imageName = "imageName"
      @update:imageName = "imageName = $event"/>

      <ContactPageTwo
      :title = "Title"
      @update:title = "Title = $event"/>
      <ContactPageThree/>

    </form>
    </div>    
  </div>
</template>

<script>
import ContactPageOne from './ContactPageOne.vue';
import ContactPageThree from './ContactPageThree.vue';
import ContactPageTwo from './ContactPageTwo.vue';
import MessageDiv from './MessageDiv.vue';
import axios from 'axios';
export default {
  components:{
    MessageDiv,
    ContactPageOne,
    ContactPageTwo,
    ContactPageThree
  },
  data() {
    return {
      BannerTitle:'',
      Title:'',
      current_image: '',
      image: null,
      informations:[],
      imageName:'',
      successMessage: '' // 在 data 中定义 successMessage
    }
  },
  created() {
    this.fetchDetails();
    this.$bus.$on('fetchContact',this.fetchDetails);
    this.successMessage = localStorage.getItem('successMessage') || ''; // 获取 successMessage
    localStorage.removeItem('successMessage'); // 清除 localStorage 中的消息
  },
  beforeDestroy(){
    this.$bus.$off('fetchContact',this.fetchDetails);
  },
  methods:{
    SentMessageDiv(message){
      this.$bus.$emit('setMessage',message);
    },
    fetchDetails(){
      axios.get(`${this.$apiurl}/api/Add&UpdateContactPage.php`)
      .then(response =>{
        const data = response.data;
        if(data.success){
          const contact = data.contact;
          this.BannerTitle = contact.banner_title;
          this.Title = contact.title;
          this.current_image = contact.image_name;
        }else{
          this.$bus.$emit('setErrorMessage', `${data.message}`);
        }
      })
      .catch(error =>{
        this.$bus.$emit('setErrorMessage', `${error}`);
        console.error(error);
      })
    },
    submitContactPage() {
      const formData = new FormData();
      formData.append('BannerTitle', this.BannerTitle);
      formData.append('Title', this.Title);
      formData.append('current_image', this.current_image);
      if(this.image) {
        formData.append('image', this.image);
      }
      axios.post(`${this.$apiurl}/api/Add&UpdateContactPage.php`,formData)
      .then(response=>{
        const data = response.data;
        if(data.success){
          this.SentMessageDiv(`${data.message}`);
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
