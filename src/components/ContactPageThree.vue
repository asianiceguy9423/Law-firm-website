<template>
  <div>
    <table class="RouterPage">
      <div class="ObjectBox ObjectBoxFlex ObjectBoxBoerderBottom PaddingLeftRight">
        <h3 class="TitleH3">資訊列表</h3>
        <router-link to="ContactInformationAdd"><button class="ItemButton">+新增資訊</button></router-link>
      </div>

      <div class="FormItem BackColorBlue ">
        <td class="ObjectBox ObjectBoxNumber">
          <th >編號</th>
        </td>
        <td class="ObjectBox">
          <th >項目(例如:電話)</th>
        </td>
        <td class="ObjectBox">
          <th >說明(例如:09-xxxxx)</th>
        </td>
        <td class="ObjectBox">
          <th >操作</th>
        </td>
      </div>

      <div class="FormItem ObjectBoxBoerderBottom FormItemToHover" 
      v-for="(information, index) in informations" :key="information.id">
        <td class="ObjectBox ObjectBoxNumber">
          <th>{{ index +1 }}</th>
        </td>
        <td class="ObjectBox">
          <th class="TextAlignLeft">{{ information.project }}</th>
        </td>
        <td class="ObjectBox">
          <th class="TextAlignLeft">{{ information.explain_project }}</th>
        </td>
        <td class="ObjectBox">
          <th class="ItemButtonTh">
            <router-link  class="ItemButton ItemButtonWidthMax hidden" :to="`ContactInformationUpdate/${information.id}`">
              編輯
            </router-link>
            <button 
            @click="DeleteIt(information.id)" 
            class="ItemButton ItemButtonWidthMax hidden" 
            type="button">
              刪除
            </button>
          </th>
        </td>
      </div> 
    </table>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  data() {
    return {
      informations:[],
    }
  },
  created() {
    this.fetchInformation();
    this.$bus.$on('fetchContactPage', this.fetchInformation);
  },
  beforeDestroy(){
    this.$bus.$off('fetchContactPage', this.fetchInformation);
  },
  methods:{
    fetchInformation(){
      axios.get(`${this.$apiurl}/api/FetchContactPageINformation.php`)
      .then(response =>{
        const dataInformation = response.data;
        if(dataInformation.success){
          this.informations = dataInformation.information;
        }else{
          this.$bus.$emit('setErrorMessage', `${response.data.message}`);
        }
      })
      .catch(error =>{
        console.log(error);
        this.$bus.$emit('setErrorMessage', '資料庫連線錯誤');
      })
    },
    DeleteIt(id){
      if(confirm('你確定要刪除這個資訊嗎')){
        axios.delete(`${this.$apiurl}/api/DeleteContactPageUnformation.php?id=${id}`)
        .then(response =>{
          const dataDelete = response.data;
          if(dataDelete.success){
            this.$bus.$emit('setMessage', `${dataDelete.message}`);
            this.fetchInformation();
          }else{
            this.$bus.$emit('setErrorMessage', `${dataDelete.message}`);
          }
        })
        .catch(error =>{
          this.eroorMessage = '刪除人員出錯了';
          console.log(error);
        })
        window.scrollTo(0, 0);
      }
    }
  }
}
</script>

<style>
</style>
