<template>
  <div>  
    <table class="RouterPage">
      <tr class="ObjectBox ObjectBoxBoerderBottom">
        <h3 class="TitleH3">Banner部分</h3>
      </tr>
      <div class="ObjectBox ObjectGrid">
        <tr class="ObjectItem">
        <td>標題</td>
        <td>
          <input 
          type="text" 
          :value="title"
          @input="$emit('update:title', $event.target.value)"
          placeholder="這邊輸入標題" 
          class="InputText">
        </td>
      </tr>

      <tr class="ObjectItem">
        <td>目前橫幅圖片</td>
        <td>
          <img v-if="current_image" :src="currentBannerUrl" width="150px">
          <div v-else class="error">尚未上傳橫幅圖片</div>
        </td>
      </tr>
      
      <tr class="ObjectItem">
        <td>選擇橫幅圖片</td>
        <td>
          <input 
          class="fileInput" 
          type="file" 
          @change="handleBannerUpload">
          <button 
          type="button" 
          class="ItemButton" 
          @click="triggerFileInput">
            選擇圖片
          </button>
          <div v-if="imageName" class="Font14">{{ imageName }}</div>
          <div v-else class="Font14">尚未更換圖片</div>
        </td>
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
    current_image:{
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
    },
  },
  computed: {
    currentBannerUrl() {
      return `${this.$apiurl}/src/assets/contact/${this.current_image}`;
    },
  },
  methods:{   
    handleBannerUpload(event) {
      this.$emit('update:image', event.target.files[0]);
      this.$emit('update:imageName', event.target.files[0] ? event.target.files[0].name : '');
    },
    triggerFileInput(){
      this.$el.querySelector('.fileInput').click();
    },
  }
}
</script>

<style>
</style>
