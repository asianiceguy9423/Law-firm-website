<template>
  <div>
    <table class="RouterPage">
        <tr class="ObjectBox ObjectBoxBoerderBottom">
          <h3 class="TitleH3">第二頁</h3>
        </tr>
        <div class="ObjectBox ObjectGrid">
          <tr class="ObjectItem">
            <td>標題</td>
            <input 
              type="text" 
              :value = title
              @input="$emit('update:title', $event.target.value)"
              placeholder="這邊輸入標題" 
            class="InputText" required>
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
    }
  }
}
</script>

<style>

</style>
