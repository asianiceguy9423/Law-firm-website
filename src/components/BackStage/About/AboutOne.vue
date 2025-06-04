<template>
  <table class="RouterPage">
    <thead>
      <tr class="ObjectBox ObjectBoxBoerderBottom">
        <th colspan="2" class="TitleH3">
          關於我們banner
        </th>        
      </tr>
    </thead>
    
    <tbody class="ObjectBox ObjectGrid">
      <tr class="ObjectItem">
        <td>標題</td>
        <td>
          <input 
            type="text"
            :value="title?.title ?? ''"
            @input="(e) => updateTitle(e, 'title')"
            placeholder="這邊輸入標題" 
            class="InputText"
          >
        </td>
      </tr>

      <tr class="ObjectItem">
        <td>副標</td>
        <td>
          <input 
            type="text" 
            :value="title?.subtitle ?? ''"
            @input="(e) => updateTitle(e, 'subtitle')"
            placeholder="這邊輸入副題" class="InputText"
          >
        </td>
      </tr>

      <tr class="ObjectItem">
        <td>目前圖片</td>
        <td>
          <img 
            v-if="bannerIMG" 
            v-lazy="bannerIMG" 
            width="150px"
          >
          <div v-else class="error">尚未上傳圖片</div>
        </td>
      </tr>

      <tr class="ObjectItem">
        <td>選擇圖片</td>
        <td>
          <input 
            class="fileInput fileInputBannerImage" 
            type="file" 
            id="fileAboutOneBannerInput"
            @change="AboutBannerUpload"
          >
          <label
            type="button"
            for="fileAboutOneBannerInput"
            class="ItemButton"
          >
            選擇圖片
          </label>
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
      type:     Object,
      default: () => ({ title: '', subtitle: '' })
    },
    bannerIMG:{
      type:     String,
      default:  ''
    },
    fileName:{
      type:     File,
      default:  null
    }
  },
  emits: [
    "update:title",
    "update:fileName"
  ],
  setup(props, {emit}){    
    const AboutBannerUpload = (event) =>{
      const file = event.target.files[0];
      if(file){
        emit("update:fileName", file);
      }
    }

    const updateTitle = (e, field) => {
      emit('update:title', {
        ...props.title,
        [field]: e.target.value
      });
    };

    return{
      AboutBannerUpload,
      updateTitle,
    }
  }
}
</script>

<style>
</style>