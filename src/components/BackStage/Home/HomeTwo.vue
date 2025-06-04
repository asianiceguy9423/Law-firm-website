<template>
  <table class="RouterPage">
    <thead>
      <tr class="ObjectBox ObjectBoxBoerderBottom">
        <th colspan="2" class="TitleH3">
          第二頁
        </th>        
      </tr>
    </thead>
    
    <tbody class="ObjectBox ObjectGrid">
      <tr class="ObjectItem">
        <td>標題</td>
        <td>
          <input 
            type="text" 
            :value = title
            @input="$emit('update:title', $event.target.value)"
            placeholder="這邊輸入標題" 
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
    }
  },
}
</script>

<style>
</style>