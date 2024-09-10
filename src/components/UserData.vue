<template>
  <div>
    <MessageDiv/>
    <IsLoading v-show="isLoaind"/>
    
    <div v-show="!isLoaind" class="ObjectBoxFlex PaddingLeftRight">
      <h1>後臺管理 </h1>
      <button @click="submitJoinPage" type="submit" class="ItemButton">確定更新</button> 
    </div>
    
    <div v-show="!isLoaind" class="PaddingLeftRight PaddingBottom">
      <form @submit.prevent="submitJoinPage" enctype="multipart/form-data" class="formGrid">
        <table class="RouterPage">
          <tr class="ObjectBox ObjectBoxBoerderBottom">
            <h3 class="TitleH3">帳號及密碼</h3>
          </tr>
          <div class="ObjectBox ObjectGrid">
            <tr class="ObjectItem">
              <td>帳號</td>
              <td>
                <input type="text" v-model="username" placeholder="這邊輸入標題" class="InputText">
              </td>
            </tr>

            <tr class="ObjectItem">
              <td>密碼</td>
              <td>
                <input type="text" v-model="password" placeholder="這邊輸入按鈕文字，建議四個字" class="InputText">
              </td>
            </tr>
          </div>
          </table>

      </form>
    </div>
    
  </div>
</template>

<script>
import axios from 'axios';
import MessageDiv from './MessageDiv.vue';
import IsLoading from './IsLoading.vue';
export default {
  components:{
    MessageDiv,
    IsLoading
  },
  data() {
    return {
      username:'',
      password:'',
      isLoaind:true,
    }
  },
  created() {
    this.fetchDetails();
  },
  methods:{
    fetchDetails(){
      axios.get(`${this.$apiurl}/api/Add&UpdateUserData.php`)
      .then(response =>{
        const data = response.data;
        if(data.success){
          const userdata = data.userdata;
          this.username = userdata.username;
          this.password = userdata.password;
        }else{
          this.$bus.$emit('setErrorMessage', `${data.message}`);
        }
      })
      .catch(error =>{
        this.$bus.$emit('setErrorMessage', '資料庫連線錯誤');
        console.error(error);
      })
      this.isLoaind = false;
    },
    submitJoinPage() {
      const formData = new FormData();
      formData.append('username', this.username);
      formData.append('password', this.password);
      axios.post(`${this.$apiurl}/api/Add&UpdateUserData.php`,formData)
      .then(response=>{
        const data = response.data;
        if(data.success){
          this.$bus.$emit('setMessage', `${data.message}`);
          this.fetchDetails();
        }else{
          this.$bus.$emit('setErrorMessage', `${data.message}`);
        }
      })
      .catch(error => {
        this.$bus.$emit('setErrorMessage', `${error}`);
      });
    }
  }
}
</script>

<style>
</style>
