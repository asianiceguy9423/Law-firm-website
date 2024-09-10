<template>
  <div>
    <table class="RouterPage">
        <tr class="ObjectBox ObjectBoxBoerderBottom">
          <h3 class="TitleH3">未來發布</h3>
        </tr>

        <div class="ObjectBox ObjectGrid">
          <tr class="labelDiv">
            <label>
              <input type="checkbox" 
              v-model="checkedDisplayWritings"
              @change="updateDisplayWritings">
            </label>
            <td class="basicObject">顯示未來發布</td>
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
            <td>介紹文字</td>
            <input
              type="text" 
              :value="text" 
              @input="$emit('update:text', $event.target.value)" 
              placeholder="這邊輸入標題" 
            class="InputText">
          </tr>

          <tr class="ObjectItem">
            <td>目前圖片</td>
            <td>
              <img v-if="currentimage" :src="currentPICImageUrl" width="150px">
              <div v-else class="Font14">尚未上傳圖片</div>
            </td>
          </tr>

          <tr class="ObjectItem">
            <td>選擇背景圖片</td>
            <td>
              <input 
              class="fileInput fileInputBanner" 
              type="file" 
              @change="PICUpload">
              <button 
              type="button" 
              class="ItemButton" 
              @click="triggerPICFileInput">
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
    text:{
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
    },
    displayWritings: Boolean
  },
  computed: {
    currentPICImageUrl() {
      return `${this.$apiurl}/src/assets/law/${this.currentimage}`;
    },
    checkedDisplayWritings: {
      get() {
        return this.displayWritings;
      },
      set(value) {
        this.$emit('update:displayWritings', value);
      }
    }
  },
  methods:{
    PICUpload(event) {
      this.$emit('update:image', event.target.files[0]);
      this.$emit('update:imageName', event.target.files[0] ? event.target.files[0].name : '');
    },
    triggerPICFileInput() {
      this.$el.querySelector('.fileInputBanner').click();
    },
    updateDisplayWritings(){
      this.$emit('update:displayWritings', !this.displayWritings);
    }
  }
}
</script>

<style>
</style>