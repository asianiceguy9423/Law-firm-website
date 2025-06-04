<template>
  <table class="RouterPage">
    <thead>
      <tr class="ObjectBox ObjectBoxBoerderBottom">
        <th class="TitleH3">Banner設定</th>
      </tr>
    </thead>    

    <tbody class="ObjectBox ObjectGrid">
      <tr class="ObjectItem">
        <td>目前圖片</td>
        <td>
          <img v-if="bannerIMG" :src="bannerIMG" width="150px">
          <div v-else class="Font14">尚未上傳圖片</div>
        </td>
      </tr>

      <tr class="ObjectItem">
        <td>選擇背景圖片</td>
        <td>
          <input 
            class="fileInput" 
            id="fileInput"
            type="file" 
            @change="BannerUpload"
          >
          <label 
            type="button" 
            for="fileInput"
            class="ItemButton" 
          >
            選擇圖片
          </label>
          <div class="Font14">
            {{ fileName ? fileName.name : '尚未更換圖片' }}
          </div>
        </td>
      </tr>

      <tr class="ObjectItem">
        <td>Banner標題</td>
        <td>
          <input
            type="text" 
            :value="bannerTitle" 
            @input="$emit('update:bannerTitle', $event.target.value)" 
            placeholder="這邊輸入標題" 
            class="InputText"
          >
        </td>       
      </tr>

      <tr class="ObjectItem">
        <td>標題</td>
        <td>
          <input 
            type="text" 
            :value="title"
            @input="$emit('update:title', $event.target.value)"
            placeholder="這邊輸入按鈕文字" 
            class="InputText"
          >
        </td>        
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  props:{
    bannerIMG:{
      type:     String,
      default:  ''
    },
    bannerTitle:{
      type:     String,
      default:  ''
    },
    title:{
      type:     String,
      default:  ''
    },
    fileName:{
      type:     File,
      default:  null
    },
  },
  emits: [
    "update:bannerTitle",
    "update:title",
    "update:fileName"
  ],
  setup(props, {emit}){
    const BannerUpload = (event) =>{
      const file = event.target.files[0];
      if(file){
        emit("update:fileName", file);
      }
    }
    return{
      BannerUpload,
    }
  }
}
</script>

<style>
</style>