<template>
  <transition name="success" @after-leave="clearMessage">
    <div v-if="successMessage" class="MessageBox SuccessColor" >{{successMessage}}</div>
    <div v-else-if="errorMessage" class="MessageBox ErrorColor">{{errorMessage}}</div>
  </transition>
</template>

<script>
import { eventBus } from '@/eventBus';
import { onMounted, onUnmounted, ref } from 'vue';

export default {
  setup(){
    const successMessage  = ref('');
    const errorMessage    = ref('');

    onMounted(() =>{
      eventBus.on('sentSuccessMessage', setSuccessMessage);
      eventBus.on('sentErrorMessage', setErrorMessage);
      }  
    );

    onUnmounted(() =>{
      eventBus.off('sentSuccessMessage', setSuccessMessage);
      eventBus.off('sentErrorMessage', setErrorMessage);
    });

    const handleAnimationEnd = () => {
      setTimeout(()=>{
        return clearMessage();
      },3000)
    };

    const clearMessage = () =>{
      successMessage.value = '';
      errorMessage.value = '';
      localStorage.removeItem('successMessage');
    }

    const setSuccessMessage = (message) =>{
      successMessage.value = message;
      return handleAnimationEnd();
    };

    const setErrorMessage = (message) =>{
      errorMessage.value = message;
      return handleAnimationEnd();
    };

    //如果佔有訊息，顯示訊息後刪除暫存訊息
    const setLocalMessage = () =>{
      const message = localStorage.getItem('successMessage');
      if(message){
        successMessage.value = message;
        handleAnimationEnd();
      }
    };
    
    onMounted(()=>{
      setLocalMessage();
    })
    onUnmounted(()=>{
      setLocalMessage();
    })

    return{
      successMessage,
      errorMessage,
      setSuccessMessage,
      setErrorMessage,
      clearMessage,
      setLocalMessage,
    }
  }
}
</script>

<style lang="scss" scoped>
.MessageBox{
  padding: 18px 25px;
  text-align: center;
  color: #ffff;
  font-size: 16px;
  font-weight: bolder;
}
</style>