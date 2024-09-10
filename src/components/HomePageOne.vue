<template>
  <div>
    <table class="RouterPage">
        <tr class="ObjectBox ObjectBoxBoerderBottom">
          <h3 class="TitleH3">首頁Banner</h3>
        </tr>

        <div class="ObjectBox ObjectGrid">
          <tr class="ObjectItem">
            <td>目前圖片</td>
            <td>
              <img v-if="currentimage" :src="currentHomeOnePICImageUrl" width="150px">
              <div v-else class="Font14">尚未上傳圖片</div>
            </td>
          </tr>

          <tr class="ObjectItem">
            <td>選擇背景圖片</td>
            <td>
              <input 
              class="fileInput fileInputBannerImage" 
              type="file" 
              @change="HomeOnePICUpload">
              <button 
              type="button" 
              class="ItemButton" 
              @click="triggerHomeOnePICFileInput">
                選擇圖片
              </button>
              <div v-if="imageName" class="Font14">{{ imageName }}</div>
              <div v-else class="Font14">尚未更換圖片</div>
            </td>
          </tr>

          <tr class="ObjectItem">
            <td>標題</td>
            <input
              type="text" 
              :value="title" 
              @input="$emit('update:title', $event.target.value)" 
              placeholder="這邊輸入標題" 
            class="InputText">
          </tr>

          <tr class="ObjectItem">
            <td>按鈕文字</td>
            <input 
              type="text" 
              :value="btn"
              @input="$emit('update:btn', $event.target.value)"
              placeholder="這邊輸入按鈕文字" 
            class="InputText">
          </tr>
        </div>
      </table>
    
  </div>
</template>

<script>
export default {
  props:{
    title:{
      type: String,
      default:''
    },
    btn:{
      type: String,
      default:''
    },
    currentimage:{
      type: String,
      default:''
    },
    image:{
      type: [String, File],
      default:''
    },
    imageName:{
      type: String,
      default:''
    }
  },
  computed: {
    currentHomeOnePICImageUrl() {
      return `${this.$apiurl}/src/assets/home/${this.currentimage}`;
    }
  },
  methods:{
    HomeOnePICUpload(event) {
      this.$emit('update:image', event.target.files[0]);
      this.$emit('update:imageName', event.target.files[0] ? event.target.files[0].name : '');
    },
    triggerHomeOnePICFileInput() {
      this.$el.querySelector('.fileInputBannerImage').click();
    },
  }
}
</script>

<style>
</style>