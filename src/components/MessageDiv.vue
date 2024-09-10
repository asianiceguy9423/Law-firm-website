<template>
  <div>
    <transition name="success" @after-leave="clearMessage">
      <div v-if="message" class="MessageBox SuccessColor" >{{message}}</div>
      <div v-if="errorMessage" class="MessageBox ErrorColor">{{errorMessage}}</div>
    </transition>
  </div>
</template>

<script>
export default {
  props:{
    successMessage:{
      type: String,
      default:''
    }
  },
  data(){
    return{
      message: '',
      errorMessage: '',
    }
  },
  created(){
    this.$bus.$on('setMessage',this.setMessage);
    this.$bus.$on('setErrorMessage', this.setErrorMessage);
    this.$bus.$on('handleAnimationEnd', this.handleAnimationEnd);

    //如果有接收到successMessage就執行以下
    if(this.successMessage){
      this.setMessage(this.successMessage)
    }
  },
  methods: {
    handleAnimationEnd(){
      setTimeout(()=>{
        this.clearMessage();
      },5000);
    },
    clearMessage(){
      if(this.message){
        this.message = '';
      }else{
        this.errorMessage = '';
      }
    },
    setMessage(message){
      this.message = message;
      this.handleAnimationEnd();
    },
    setErrorMessage(errorMessage){
      this.errorMessage = errorMessage;
      this.handleAnimationEnd();
    }
  },
  beforeDestroy(){
    this.$bus.$off('setMessage',this.setMessage);
    this.$bus.$off('errorMessage', this.setErrorMessage);
    this.$bus.$off('handleAnimationEnd', this.handleAnimationEnd);
  }
}
</script>

<style scoped>
.MessageBox{
  padding: 18px 25px;
  text-align: center;
  color: #ffff;
  font-size: 16px;
  font-weight: bolder;
}

</style>