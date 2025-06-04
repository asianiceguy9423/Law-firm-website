<template>
  <div class="componentDiv">
    <table class="RouterPage">
      <thead>
        <tr class="ObjectBox ObjectBoxBoerderBottom">
          <th colspan="2">
            <h3 class="TitleH3">未來發布設定</h3>
          </th>        
        </tr>
      </thead>      

      <tbody class="ObjectBox ObjectGrid">
        <tr class="ObjectItem">
          <td>顯示</td>
          <td>
            <input
              type="checkbox"
              :checked="(display == 1)"
              @change="toogleDisplay($event.target.checked)"
            >
          </td>          
        </tr>

        <tr class="ObjectItem">
          <td>目前圖片</td>
          <td>
            <img v-if="image" v-lazy="image" width="150px">
            <div v-else class="Font14">尚未上傳圖片</div>
          </td>
        </tr>

        <tr class="ObjectItem">
          <td>選擇顯示圖片</td>
          <td>
            <input 
              class="fileInput" 
              id="fileInput"
              type="file" 
              @change="IMGUpload"
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
          <td>名稱</td>
          <td>
            <input
              type="text" 
              :value="name" 
              @input="$emit('update:name', $event.target.value)" 
              placeholder="輸入名稱" 
              class="InputText"
            >
          </td>          
        </tr>

        <tr class="ObjectItem">
          <td>說明</td>
          <td>
            <input
              type="text" 
              :value="content" 
              @input="$emit('update:content', $event.target.value)" 
              placeholder="輸入說明" 
              class="InputText"
            >
          </td>          
        </tr>
      </tbody>
    </table>
  </div>  
</template>

<script>
import { useStore } from 'vuex'

export default {
  props:{
    name:{
      type:String,
      default:'',
    },
    content:{
      type:String,
      default:'',
    },
    image:{
      type:String,
      default:'',
    },
    display:{
      type:String,
      default:'',
    },
    fileName:{
      type:     File,
    },
  },
  emits: [
    "update:name",
    "update:content",
    "update:fileName",
  ],
  setup(props, {emit}){
    const store = useStore();

    const toogleDisplay = (checked) =>{
      const newDisplay = checked ? '1' : '0';
      store.dispatch("ArticlesFuturerReleaseStore/updateDisplay" ,newDisplay) 
    }

    const IMGUpload = (event) =>{
      const file = event.target.files[0];
      if(file){
        emit("update:fileName", file);
      }
    }

    return{
      toogleDisplay,
      IMGUpload,
    }
  }
}
</script>

<style>

</style>