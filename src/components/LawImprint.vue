<template>
  <div>
    <table class="RouterPage">
      <div class="ObjectBox ObjectBoxFlex ObjectBoxBoerderBottom PaddingLeftRight">
        <h3 class="TitleH3">資訊列表</h3>
        <router-link to="LawImprintAdd"><button class="ItemButton">新增文章</button></router-link>
      </div>
      <div class="FormItem BackColorBlue ">
        <td class="ObjectBox ObjectBoxNumber">
          <th >編號</th>
        </td>
        <td class="ObjectBox">
          <th >文章標題</th>
        </td>
        <td class="ObjectBox">
          <th >標籤</th>
        </td>
        <td class="ObjectBox">
          <th >文章圖片</th>
        </td>
        <td class="ObjectBox">
          <th >操作</th>
        </td>
      </div>

      <div class="FormItem ObjectBoxBoerderBottom FormItemToHover" v-for="(law, index) in laws" :key="law.id">
        <td class="ObjectBox ObjectBoxNumber">
          <th>{{ index +1 }}</th>
        </td>
        <td class="ObjectBox">
          <th class="TextAlignLeft">{{ law.title }}</th>
        </td>
        <td class="ObjectBox">
          <th class="TextAlignLeft">{{ law.class }}</th>
        </td>
        <td class="ObjectBox">
          <th><img v-if="law.big_image" :src="getImagUrl(law.big_image)" width="150px" height="150px"></th>
        </td>
        <td class="ObjectBox">
          <th class="ItemButtonTh">
            <router-link class="ItemButton ItemButtonWidthMax hidden" :to="`LawImprintAddUpdate/${law.id}`">
              編輯
            </router-link>
            <button @click="Deletelaw(law.id, law.big_image, law.banner_image)" class="ItemButton ItemButtonWidthMax hidden" type="button">刪除</button>
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
      laws: [],
      isLoaind:true,
    }
  },
  created() {
    this.fetchDetails();
    this.$bus.$on('fetchLaw', this.fetchDetails);
  },
  beforeDestroy(){
    this.$bus.$off('fetchLaw', this.fetchDetails);
  },
  methods: {
    GetLawAddMessage(message){
      this.$bus.$emit('setMessage',message);
    },
    fetchDetails() {
      axios.get(`${this.$apiurl}/api/fetchLawWriting.php`)
        .then(response => {
          const data = response.data;
          if (data.success) {
            this.laws = data.law;
          } else {
            this.$bus.$emit('setErrorMessage', `${data.message}`);
          }
        })
        .catch(error => {
          this.$bus.$emit('setErrorMessage', `${error}`);
          console.error(error);
        })
        this.isLoaind = false;
    },
    Deletelaw(id, big_image, banner_image) {
      if (confirm('你確定要刪除這個文章嗎')) {
        axios.delete(`${this.$apiurl}/api/DeleteLawWriting.php?id=${id}&big_image=${big_image}&banner_image=${banner_image}`)
          .then(response => {
            const data = response.data;
            if (data.success) {
              this.$bus.$emit('setMessage', `${data.message}`);
              this.fetchDetails();
            } else {
              this.$bus.$emit('setErrorMessage', `${data.message}`);
            }
          })
          .catch(error => {
            this.$bus.$emit('setErrorMessage', `${error}`);
            console.log(error);
          });
      }
      window.scroll(0,0);
    },
    getImagUrl(image) {
      return `${this.$apiurl}/src/assets/law/${image}`; 
    }
  }
}
</script>

<style>

</style>
