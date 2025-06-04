<template>
  <table class="RouterPage">
    <thead>
      <tr class="ObjectBox ObjectBoxFlex ObjectBoxBoerderBottom PaddingLeftRight">
        <th colspan="4" class="TitleH3">資訊列表</th>
        <th colspan="1">
          <router-link to="/BackStage/Contact/InfoAdd">
            <button class="ItemButton">
              +新增資訊
            </button>
          </router-link>
        </th>        
      </tr>

      <tr class="FormItem BackColorBlue">
        <th class="FormItemObjectNumber ObjectBoxNumber ObjectToMinWidthDisplayNone">
          編號        
        </th>
        <th class="FormItemObjectNumber ObjectBoxNumber">
          顯示     
        </th>
        <th class="FormItemObjectBox">
          項目(例如:電話)      
        </th>
        <th class="FormItemObjectBox ObjectToMinWidthDisplayNone">
          說明(例如:09-xxxxx)       
        </th>
        <th class="FormItemObjectBox">
            操作       
        </th>
      </tr>
    </thead>     

    <tbody>
      <tr 
        class="FormItem ObjectBoxBoerderBottom FormItemToHover" 
        v-for="(infoItem, index) in infoDetails" 
        :key="infoItem.id"
      >
        <td class="FormItemObjectNumber ObjectBoxNumber ObjectToMinWidthDisplayNone">
          {{ index +1 }}
        </td>
        <td class="FormItemObjectNumber ObjectBoxNumber">
          <input 
            type="checkbox"
            :checked="Number(infoItem.display) === 1"
            @change="toggleDisplay(infoItem, $event.target.checked)"
          >
        </td>
        <td class="FormItemObjectBox TextAlignLeft">
          {{ infoItem.project }}
        </td>
        <td class="FormItemObjectBox ObjectToMinWidthDisplayNone TextAlignLeft">
          {{ infoItem.explain_project }}
        </td>
        <td class="FormItemObjectBox">
          <div class="ItemButtonTh">
            <router-link  
              class="ItemButton ItemButtonWidthMax hidden" 
              :to="{
                path: `/BackStage/Contact/ContactInfoEdit/${infoItem.id}`
              }"
            >
              編輯
            </router-link>
            <button 
              @click="DeleteIt(infoItem)" 
              class="ItemButton ItemButtonWidthMax hidden" 
              type="button"
            >
              刪除
            </button>
          </div>
        </td>
      </tr> 
    </tbody>
  </table>
</template>

<script>
import { useStore } from 'vuex';

export default {
  props:{
    infoDetails:{
      type:     Array,
      default: () => []
    },
  },
  emits: [
    "update:infoDetails",
  ],
  setup(){
    const store = useStore();

    const toggleDisplay = async (infoItem, isChecked) => {
      const newDisplayvalue = isChecked? 1:0;
      await store.dispatch(
        "ContactStore/updateInfoDisplay", 
        {
          id: infoItem.id,
          display: newDisplayvalue,
        });
    };
    const DeleteIt = async(Info)=>{
      if(confirm('確定要刪除這個資訊嗎?')){
        try{
          const response = await store.dispatch('ContactStore/DeleteInfo', Info)
          if(response && response.success){
            alert('刪除成功')
          } else {
            alert('刪除失敗，請稍後再試');
          }
        } catch (error) {
          console.error('刪除時發生錯誤:', error);
        }        
      }
    }

    return{
      toggleDisplay,
      DeleteIt,
    }
  }
}
</script>

<style lang="scss" scoped>
.FormItemObjectBox{
  display: flex;
  padding: 16px 20px;
  width: 24%;
}
.FormItemObjectNumber{
  display: flex;
  padding: 16px 20px;
  width: 6%;
}
@media (max-width:1024px){
  .FormItemObjectBox{
    padding: 12px 16px;
    width: 24%;
  }
  .FormItemObjectNumber{
    padding: 12px 16px;
  }
}
@media (max-width:768px) {
  .FormItemObjectBox{
    width: 28%;
  }
  .FormItemObjectNumber{
    padding: 12px 16px;
    width: 10%;
  }
  .ObjectToMinWidthDisplayNone{
    display: none;
  }  
}
</style>