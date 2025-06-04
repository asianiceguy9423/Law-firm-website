<template>
  <table class="RouterPage">
    <thead class="ObjectBox ObjectBoxBoerderBottom">
      <th class="TitleH3">店家資訊</th>
    </thead>

    <tbody class="ObjectBox ObjectGrid">
      <tr  
        class="labelDiv"
        v-for="(StoreLinkItem, index) in storeLink"
        :key="StoreLinkItem.id"
      >
        <label>
          <input 
            type="checkbox"
            :checked="(StoreLinkItem.display)"
            @change="updateStoreLinkDisplay(index, $event.target.checked)"
          >
        </label>

        <td class="basicObject">
          <th>{{ StoreLinkItem.title }}</th>
        </td>
        
        <td>
          <input 
            type="text" 
            class="InputText" 
            placeholder="輸入項目"
            v-model="(StoreLinkItem.link)"
            @input="updateStoreLink(index, $event.target.value)"
          >
        </td>
      </tr>
    </tbody>    
  </table>
</template>

<script>
import { useStore } from 'vuex';

export default {
  props:{
    storeLink:{
      type:     Array,
      default:  () => [],
    }
  },
  emit:['update:storeLink'],
  setup(props, {emit}){
    // console.log(JSON.stringify(props.storeLink, null, 2))
    const store=  useStore();
    //打包成array
    const emitStoreLinkUpdate = (updatedStoreLink) => {
      emit('update:storeLink', updatedStoreLink);
    };

    const updateStoreLink = (index, newLink) => {
      const updatedStoreLink = [...props.storeLink];
      updatedStoreLink[index] = { ...updatedStoreLink[index], link: newLink };
      emitStoreLinkUpdate(updatedStoreLink);
    };

    //改變display，但只將目前操作的display交給vuex處理
    const updateStoreLinkDisplay = (index, newDisplay) => {
      const StoreLinkItem = props.storeLink[index];
      store.dispatch("WebsiteInformation/updatStoreLinkDisplay", {
        name: StoreLinkItem.name, // ✅ 傳遞 name 代替 id
        newDisplay
      });
      // console.log(`✅ 變更 number: ${StoreLinkItem.name} display 為: ${newDisplay}`);
    };

    return{
      updateStoreLink,
      updateStoreLinkDisplay,
    }
  }

}
</script>

<style lang="scss" scoped>
input{
  font-size: 16px;
}
.basicObject{
  th{
    font-weight: normal;
  }
}  
</style>