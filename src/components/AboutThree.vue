<template>
  <div>
    <table class="RouterPage">
      <div class="ObjectBox ObjectBoxFlex ObjectBoxBoerderBottom PaddingLeftRight">
        <h3 class="TitleH3">事件列表</h3>
        <router-link to="AbouPageThreeAdd"><button class="ItemButton" type="button">+新增人員</button></router-link>
      </div>
      <div class="FormItem BackColorBlue">
        <td class="ObjectBox ObjectBoxNumber">
          <th>編號</th>
        </td>
        <td class="ObjectBox">
          <th>人名</th>
        </td>
        <td class="ObjectBox">
          <th>圖片</th>
        </td>
        <td class="ObjectBox">
          <th>操作</th>
        </td>
      </div>

      <div class="FormItem ObjectBoxBoerderBottom FormItemToHover" v-for="(about, index) in abouts" :key="about.id">
        <td class="ObjectBox ObjectBoxNumber">
          <th>{{ index +1 }}</th>
        </td>
        <td class="ObjectBox">
          <th class="TextAlignLeft">{{ about.personName }}</th>
        </td>
        <td>
          <th>
            <img v-if="about.image_name" :src="getImagUrl(about.image_name)" width="150px">
            <div v-else class="error">沒有添加圖片</div>
          </th>
        </td>
        <td class="ObjectBox">
          <th class="ItemButtonTh">
            <router-link class="ItemButton ItemButtonWidthMax hidden" :to="`AbouPageThreeUpdate/${about.id}`">
              編輯
            </router-link>
            <button @click="DeleteAbout(about.id, about.image_name)" class="ItemButton ItemButtonWidthMax hidden" type="button">刪除</button>
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
      abouts: [],
    }
  },
  created() {
    this.fetchabout();
    this.$bus.$on('fetchAboutThree', this.fetchabout);
  },
  beforeDestroy() {
    this.$bus.$on('fetchAboutThree', this.fetchabout);
  },
  methods: {
    fetchabout() {
      axios.get(`${this.$apiurl}/api/FetchAboutPageThree.php`)
      .then(response => {
        const data = response.data;
        if (data.success) {
          this.abouts = data.abouts;
        } else {
          this.$bus.$emit('setErrorMessage', `${data.message}`);
        }
      })
      .catch(error => {
        this.$bus.$emit('setErrorMessage', '資料庫連線錯誤');
        console.error(error);
      });
    },
    getImagUrl(image_name) {
      return `${this.$apiurl}/src/assets/about/${image_name}`;
    },
    DeleteAbout(id, image_name) {
      if (confirm('你確定要刪除這個人員嗎')) {
        axios.delete(`${this.$apiurl}/api/DeleteAboutPageThreePerson.php?id=${id}&image_name=${image_name}`)
        .then(response => {
          const data = response.data;
          if (data.success) {
            this.$bus.$emit('setMessage', `${data.message}`);
            this.fetchabout();
          } else {
            this.$bus.$emit('setErrorMessage', `${data.message}`);
          }
        })
        .catch(error => {
          this.$bus.$emit('setErrorMessage', `${error}`);
          console.log(error);
        });
        window.scrollTo(0, 0);
      }
    }
  }
}
</script>

<style>
</style>
