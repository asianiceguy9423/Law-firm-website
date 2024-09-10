<template>
  <div>
    <MessageDiv/>
    <IsLoading v-show="isLoad"/>

    <div v-show="!isLoad" class="FlexBoxBottom PaddingLeftRight">
      <div>
        <div class="LinkButtonMarginLeft">
          <button @click="goBack" class="PointButton PointMargin" type="button">聯絡我們</button>
          <font-awesome-icon :icon="['fas', 'angle-right']" style="color: #acafc4;" class="PointMargin"/>
          <button class="PointButton" type="button">新增資訊</button>
        </div>
        <h1>更新資訊 </h1>
      </div>
      <div>
        <button @click="goBack" type="button" class="ItemButton ItemButtonWhite">取消</button>
        <button @click="submitInformation" type="submit" class="ItemButton">確定更新</button>
      </div>
    </div>

      <form @submit.prevent="submitInformation" class="PaddingLeftRight">
        <table class="RouterPage">
          <tr class="ObjectBox ObjectBoxBoerderBottom">
            <h1 class="TitleH3">目前資訊 </h1>
          </tr>
          <div class="ObjectBox ObjectGrid">
            <tr class="ObjectItem">
            <td>項目(例如:電話):</td>
            <td>
              <input type="text" v-model="project" placeholder="這邊輸入項目" class="InputText" required>
            </td>
          </tr>
          <tr class="ObjectItem">
            <td>說明(例如:09-xxxxx)</td>
            <td>
              <input type="text" v-model="explain" placeholder="這邊輸入說明" class="InputText" required>
            </td>
          </tr>
          </div>
        </table>
      </form>
    
  </div>
</template>

<script>
import MessageDiv from './MessageDiv.vue';
import IsLoading from './IsLoading.vue';
import axios from 'axios';
export default {
  components:{
    MessageDiv,IsLoading
  },
  data() {
    return {
      id: this.$route.params.id,
      project:'',
      explain:'',
      isLoad:true,
    }
  },
  created(){
    this.fetchDetails();
  },
  watch:{
    '$route.params.id':function(newId, oldId){
      if(newId !== oldId){
        this.id = newId;
        this.fetchDetails();
      }
    }
  },
  methods:{
    fetchDetails(){
      axios.get(`${this.$apiurl}/api/UpdateContactInformation.php?id=${this.id}`)
      .then(response =>{
        const data = response.data[0];
        if(data){
          this.project = data.project;
          this.explain = data.explain_project;
        }else{
          this.$bus.$emit('setErrorMessage', `${data.message}`);          
        }
      })
      .catch(error =>{
        this.$bus.$emit('setErrorMessage', `${error}`);
        console.error(error);
      })
      this.isLoad = false;
      window.scrollTo(0, 0);
    },
    submitInformation() {
      const formData = new FormData();
      formData.append('id', this.id);
      formData.append('project', this.project);
      formData.append('explain', this.explain);
      axios.post(`${this.$apiurl}/api/UpdateContactInformation.php`,formData)
      .then(response => {
        const data = response.data;
        if(data.success){
          localStorage.setItem('successMessage', `${data.message}`);
          this.$router.push('/BackStage/ContactPage');
          this.$bus.$emit('fetchContactPage');
        }else{
          this.$bus.$emit('setErrorMessage', `${data.message}`);
        }
      })
      .catch(error =>{
        this.$bus.$emit('setErrorMessage', `${error}`);
      });
    },
    goBack() {
      this.$router.go(-1);
    }
  }
}
</script>

<style>
</style>
