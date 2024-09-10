<template>
  <div>    
    <table class="RouterPage">
      <tr class="ObjectBox ObjectBoxBoerderBottom">
        <h3 class="TitleH3">關於我們banner</h3>
      </tr>
      <div class="ObjectBox ObjectGrid">
        <tr class="ObjectItem">
          <td>標題</td>
          <td>
            <input type="text"
            :value="title"
            @input="$emit('update:title', $event.target.value)"
            placeholder="這邊輸入標題" 
            class="InputText">
          </td>
        </tr>

        <tr class="ObjectItem">
          <td>副標</td>
          <td>
            <input type="text" 
            :value="subTitle"
            @input="$emit('update:subTitle', $event.target.value)"
            placeholder="這邊輸入副題" class="InputText">
          </td>
        </tr>

        <tr class="ObjectItem">
          <td>目前圖片</td>
          <td>
            <img v-if="currentImageOne" 
            :src="currentImageUrl" 
            width="150px">
            <div v-else class="error">尚未上傳圖片</div>
          </td>
        </tr>

        <tr class="ObjectItem">
          <td>選擇圖片</td>
          <td>
            <input class="fileInput fileInputBannerImage" 
            type="file" 
            @change="AboutOnePicUpload">
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
    title:{
      type: String,
      default:''
    },
    subTitle:{
      type: String,
      default:''
    },
    currentImageOne:{
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
      return `${this.$apiurl}/src/assets/about/${this.currentImageOne}`;
    }
  },
  methods: {
    AboutOnePicUpload(event) {
      this.$emit('update:image', event.target.files[0]);
      this.$emit('update:imageName', event.target.files[0] ? event.target.files[0].name : '');
    },
    triggerFileInput(){
      this.$el.querySelector('.fileInputBannerImage').click();
    },
  }
}
</script>

<style>
</style>
