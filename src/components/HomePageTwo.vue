<template>
  <div>
    <table class="RouterPage">
      <div class="ObjectBox ObjectBoxFlex ObjectBoxBoerderBottom PaddingLeftRight">
        <h3 class="TitleH3">事件列表</h3>
        <router-link to="HomePageTwoAdd"><button class="ItemButton" type="button">+增加事件</button></router-link>
      </div>

      <div class="FormItem BackColorBlue ">
        <td class="ObjectBox ObjectBoxNumber">
          <th >編號</th>
        </td>
        <td class="ObjectBox">
          <th >事件名稱</th>
        </td>
        <td class="ObjectBox">
          <th >事件說明</th>
        </td>
        <td class="ObjectBox">
          <th >事件圖片</th>
        </td>
        <td class="ObjectBox">
          <th >操作</th>
        </td>
      </div>

      <div
        class="FormItem ObjectBoxBoerderBottom FormItemToHover"
        v-for="(happening, index) in happenings" :key="happening.id">
        <td class="ObjectBox ObjectBoxNumber">
          <th>{{ index +1 }}</th>
        </td>
        <td class="ObjectBox">
          <th class="TextAlignLeft">{{ happening.home_two_title }}</th>
        </td>
        <td class="ObjectBox">
          <th class="TextAlignLeft">{{ happening.home_two_exp }}</th>
        </td>
        <td class="ObjectBox">
          <th>
            <img v-if="happening.home_two_image" :src="getImagUrl(happening.home_two_image)" width="150px" height="150px" >
          </th>
        </td>
        <td class="ObjectBox">
          <th class="ItemButtonTh">
            <router-link class="ItemButton ItemButtonWidthMax hidden" :to="`HomePageTwoUpdate/${happening.id}`">
                編輯
            </router-link>
            <button
            @click="DeleteHappening(happening.id, happening.home_two_image)"
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
      happenings:[],
    }
  },
  created() {
    this.fetchDetails();
    this.$bus.$on('fetchHomeTwo', this.fetchDetails);
  },
  beforeDestroy(){
    this.$bus.$off('fetchHomeTwo', this.fetchDetails);
  },
  methods:{
    fetchDetails(){
      axios.get(`${this.$apiurl}/api/fetchHomePageTwo.php`)
      .then(response =>{
        const data = response.data;
        if(data.success){
          this.happenings = data.happening;
        }else{
          this.$bus.$emit('setErrorMessage', `${response.data.message}`);
        }
      })
      .catch(error =>{
        console.error(error);
        this.$bus.$emit('setErrorMessage', '資料庫連線錯誤');
      })
    },
    DeleteHappening(id, home_two_image){
      if(confirm('你確定要刪除這個事件嗎')){
        axios.delete(`${this.$apiurl}/api/DeleteHomePagetwo.php?id=${id}&home_two_image=${home_two_image}`)
        .then(response =>{
          const data = response.data;
          if(data.success){
            this.$bus.$emit('setMessageToHome',`${data.message}`);
            this.fetchDetails();
          }else{
            this.$bus.$emit('setErrorMessage', `${data.message}`);
          }
        })
        .catch(error =>{
          this.$bus.$emit('setErrorMessage', '刪除事件出錯了');
          console.log(error);
        });
        window.scrollTo(0, 0); 
      }
    },
    getImagUrl(home_two_image){
      return `${this.$apiurl}/src/assets/home/${home_two_image}`;      
    },
  }
}
</script>

<style>
</style>
