<template>
  <table class="RouterPage">
    <thead>
      <tr class="ObjectBox ObjectBoxBoerderBottom">
        <th colspan="2" class="TitleH3">
          第三頁
        </th>        
      </tr>
    </thead>
    
    <tbody class="ObjectBox ObjectGrid">
      <tr class="ObjectItem">
        <td>目前背景圖片</td>
        <td>
          <img v-if="homeThreeIMG" v-lazy="homeThreeIMG" width="150px">
          <div v-else class="Font14">尚未上傳圖片</div>
        </td>
      </tr>

      <tr class="ObjectItem">
        <td>選擇背景圖片</td>
        <td>
          <input
            class="fileInput fileInputBigImage"
            id="fileHomeThreeInput"
            type="file" 
            @change="homeThreeIMGUpload"
          >
          <label 
            type="button" 
            for="fileHomeThreeInput"
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
            @input = "$emit('update:content', $event.target.value)"
            placeholder="這邊輸入內文"
            class="InputText"
          ></textarea>
        </td>        
      </tr>
      <tr class="ObjectItem">
        <td>按鈕文字</td>
        <td>
          <input 
            type="text" 
            :value="btn"
            @input = "$emit('update:btn', $event.target.value)"
            placeholder="這邊輸入按鈕文字，建議四個字"
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
    title:{
      type:     String,
      default:  ''
    },
    content:{
      type:     String,
      default:  ''
    },
    homeThreeIMG:{
      type:     String,
      default:  ''
    },
    btn:{
      type:     String,
      default:  ''
    },
    fileName:{
      type:     File,
      default:  null
    },
  },
  emit: [
    "update:fileName",
    "update:title",
    "update:content",
    "update:btn"
  ],
  setup(props, {emit}){
    const homeThreeIMGUpload = (event) =>{
      const file = event.target.files[0];
      if(file){
        emit("update:fileName", file);
      }
    }

    return{
      homeThreeIMGUpload,
    }
  }

}
</script>

<style>

</style>