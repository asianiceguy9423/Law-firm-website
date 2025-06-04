<template>
  <table class="RouterPage">
    <thead>
      <tr class="ObjectBox ObjectBoxBoerderBottom">
        <th colspan="2" class="TitleH3">
          事務所理念
        </th>        
      </tr>
    </thead>
    
    <tbody class="ObjectBox ObjectGrid">
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
        <td>內文</td>
        <td>
          <textarea 
            :value="content" 
            @input="$emit('update:content', $event.target.value)" 
            placeholder="這邊輸入內文" 
            class="InputText"
          ></textarea>
        </td>
      </tr>
      <tr class="ObjectItem">
        <td>目前圖片</td>
        <td>
          <img 
            v-if="personIMG" 
            v-lazy="personIMG" 
            width="150px"
          >
          <div v-else class="error">尚未上傳圖片</div>
        </td>
      </tr>

      <tr class="ObjectItem">
        <td>選擇圖片</td>
        <td>
          <input 
            class="fileInput fileInputPersonImage" 
            type="file" 
            id="fileAboutTwoPersonInput"
            @change="AboutPersonIMGUpload"
          >
          <label 
            for="fileAboutTwoPersonInput"
            type="button"
            class="ItemButton"
          >選擇圖片</label>
          <div class="Font14">{{ fileName?.name || '尚未更換圖片' }}</div>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  props:{
    title:{
      type:     String,
      default:  ''
    },
    content:{
      type:     String,
      default:  ''
    },
    personIMG:{
      type:     String,
      default:  ''
    },
    fileName:{
      type:     File,
      default:  null
    }
  },

  emit: [
    "update:title",
    "update:content",
    "update:fileName"
  ],

  setup(props, {emit}){
    const AboutPersonIMGUpload = (event) =>{
      const file = event.target.files[0];
      if(file){
        emit("update:fileName", file)
      }
    } 
    return{
      AboutPersonIMGUpload,
    }
  }

}
</script>

<style>

</style>