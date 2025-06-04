<template>
  <table class="RouterPage">
    <thead>
      <tr class="ObjectBox ObjectBoxBoerderBottom">
        <th colspan="2" class="TitleH3">
          第三頁背景圖片
        </th>        
      </tr>
    </thead>
   
    <tbody class="ObjectBox ObjectGrid">
      <tr class="ObjectItem">
        <td>目前圖片</td>
        <td>
          <img 
            v-if="BKIMG" 
            v-lazy="BKIMG" 
            width="150px"
          >
          <div v-else class="error">尚未上傳圖片</div>
        </td>
      </tr>

      <tr class="ObjectItem">
        <td>選擇圖片</td>
        <td>
          <input 
            class="fileInput fileInputBK" 
            type="file"
            id="fileAbouThreeBKInput" 
            @change="AboutThreeBKUpload"
          >
          <label 
            class="ItemButton"
            type="button"
            for="fileAbouThreeBKInput"
          >
            選擇圖片
          </label>
          <div class="Font14">
            {{ fileName?.name || '尚未更換圖片' }}
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  props:{
    BKIMG:{
      type:     String,
      default:  ''
    },
    aboutMember:{
      type:     String,
      default:  ''
    },
    fileName:{
      type:     File,
      default:  null
    }
  },

  emits:[
    "update:BKIMG",
    "update:aboutMember",
    "update:fileName"
  ],

  setup(props, {emit}){
    const AboutThreeBKUpload = (event) =>{
      const file = event.target.files[0];
      if(file){
        emit("update:fileName", file)
      }
    }
    return{
      AboutThreeBKUpload,
    }
  }
}
</script>

<style>

</style>