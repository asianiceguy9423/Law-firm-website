<template>
  <div class="componentDiv">
    <table class="RouterPage">
      <thead class="ObjectBox ObjectBoxBoerderBottom">
        <th class="TitleH3">店家LOGO</th>
      </thead>

      <tbody class="ObjectBox ObjectGrid">
        <tr class="ObjectItem">
          <td>目前圖片</td>
          <td>
            <img v-if="logoIMG" :src="logoIMG" width="150px">
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
              @change="logoUpload"
            >
            <label 
              type="button" 
              for="fileInput"
              class="ItemButton" 
            >
              選擇圖片
            </label>
            <div class="Font14">
              {{ logoFileName ? logoFileName.name : '尚未更換圖片' }}
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>  
</template>

<script>
export default {
  props:{
    logoIMG:{
      type:     String,
      default:  ''
    },
    logoFileName:{
      default:  null
    },
  },
  emits: [
    "update:logoFileName"
  ],
  setup(props, {emit}){
    const logoUpload = (event) =>{
      const file = event.target.files[0];
      if(file){
        emit("update:logoFileName", file);
      }
    }
    return{
      logoUpload,
    }
  }
}
</script>

<style>
</style>