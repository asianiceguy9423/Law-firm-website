<template>
  <div class="componentDiv">
    <table class="RouterPage">
      <thead>
        <tr class="ObjectBox ObjectBoxBoerderBottom">
          <th colspan="2" class="TitleH3">
            首頁Banner
          </th>          
        </tr>
      </thead>     

      <tbody class="ObjectBox ObjectGrid">
        <tr class="ObjectItem">
          <td>目前圖片</td>
          <td>
            <img v-if="bannerIMG" v-lazy="bannerIMG" width="150px">
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
              @change="HomeBannerUpload"
            >
            <label 
              type="button" 
              for="fileInput"
              class="ItemButton" 
            >
              選擇圖片
            </label>
            <div class="Font14">
              {{ fileName?.name || '尚未更換圖片' }}
            </div>
          </td>
        </tr>

        <tr class="ObjectItem">
          <td>標題</td>
          <td>
            <input
              type="text" 
              :value="title" 
              @input="$emit('update:title', $event.target.value)" 
              placeholder="這邊輸入標題" 
              class="InputText"
            >
          </td>          
        </tr>

        <tr class="ObjectItem">
          <td>按鈕文字</td>
          <td>
            <input 
              type="text" 
              :value="buttonText"
              @input="$emit('update:buttonText', $event.target.value)"
              placeholder="這邊輸入按鈕文字" 
              class="InputText"
            >
          </td>          
        </tr>
      </tbody>
    </table>
  </div>  
</template>

<script>
export default {
  props:{
    bannerIMG:{
      type:     String,
      default:  ''
    },
    title:{
      type:     String,
      default:  ''
    },
    buttonText:{
      type:     String,
      default:  ''
    },
    fileName:{
      type:     File,
      default:  null
    },
  },
  emits: [
    "update:title",
    "update:buttonText",
    "update:fileName"
  ],
  setup(props, {emit}){
    const HomeBannerUpload = (event) =>{
      const file = event.target.files[0];
      if(file){
        emit("update:fileName", file);
      }
    }
    return{
      HomeBannerUpload,
    }
  }
}
</script>

<style>
</style>