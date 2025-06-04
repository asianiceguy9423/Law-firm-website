<template>
  <table class="RouterPage">
    <thead class="ObjectBox ObjectBoxBoerderBottom">
      <th class="TitleH3">店家資訊</th>
    </thead>

    <tbody class="ObjectBox ObjectGrid">
      <tr  
        class="labelDiv"
        v-for="(StoreInfoItem, index) in storeInfo"
        :key="StoreInfoItem.id"
      >
        <label>
          <input 
            type="checkbox"
            :checked="(StoreInfoItem.display)"
            @change="updatStoreInfoDisplay(index, $event.target.checked)"
          >
        </label>

        <td class="basicObject">
          <th>{{ StoreInfoItem.title }}</th>
        </td>
        
        <td>
          <input 
            type="text" 
            class="InputText" 
            placeholder="輸入項目"
            v-model="(StoreInfoItem.detail)"
            @input="updateStoreInfo(index, $event.target.value)"
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
    storeInfo:{
      type:     Array,
      default:  () => [],
    }
  },
  emit:['update:storeInfo'],
  setup(props, {emit}){
    const store=  useStore();
    //打包成array
    const emitstoreInfoUpdate = (updatedStoreInfo) => {
      emit('update:storeInfo', updatedStoreInfo);
    };

    const updateStoreInfo = (index, newName) => {
      const updatedStoreInfo = [...props.storeInfo];
      updatedStoreInfo[index] = { ...updatedStoreInfo[index], detail: newName };
      emitstoreInfoUpdate(updatedStoreInfo);
    };

    const updatStoreInfoDisplay = (index, newDisplay) => {
      const updatedStoreInfo = [...props.storeInfo];
      updatedStoreInfo[index] = { ...updatedStoreInfo[index], display: newDisplay };
      emitstoreInfoUpdate(updatedStoreInfo);

      store.dispatch("WebsiteInformation/updatStoreInfoDisplay", {
        name: updatedStoreInfo[index].name,
        newDisplay
      });
    };

    return{
      updateStoreInfo,
      updatStoreInfoDisplay,
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