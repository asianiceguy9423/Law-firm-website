<template>
  <div>    
    <table class="RouterPage">
      <tr class="ObjectBox ObjectBoxBoerderBottom">
        <h3 class="TitleH3">背景圖片</h3>
      </tr>
      <div class="ObjectBox ObjectGrid">
        <tr class="ObjectItem">
          <td>目前圖片</td>
          <td>
            <img v-if="currentImageThreeBK" 
            :src="currentImageUrl" 
            width="150px">
            <div v-else class="error">尚未上傳圖片</div>
          </td>
        </tr>

        <tr class="ObjectItem">
          <td>選擇圖片</td>
          <td>
            <input class="fileInput fileInputBK" 
            type="file" 
            @change="AboutThreeBKUpload">
            <button type="button" 
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
    currentImageThreeBK:{
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
    currentImageUrl() {
      return `${this.$apiurl}/src/assets/about/${this.currentImageThreeBK}`;
    }
  },
  methods: {
    AboutThreeBKUpload(event) {
      this.$emit('update:image', event.target.files[0]);
      this.$emit('update:imageName', event.target.files[0] ? event.target.files[0].name : '');
    },
    triggerFileInput(){
      this.$el.querySelector('.fileInputBK').click();
    },
  }
}
</script>

<style>
</style>
