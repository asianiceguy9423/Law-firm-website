<template>
  <table class="RouterPage">
    <thead>
      <tr class="ObjectBox ObjectBoxFlex ObjectBoxBoerderBottom PaddingLeftRight">
        <th colspan="4" class="TitleH3">人員列表</th>
        <th>
          <router-link to="/BackStage/About/MemberAdd">
            <button class="ItemButton" type="button">+新增人員</button>
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
          人名      
        </th>
        <th class="FormItemObjectBox ObjectToMinWidthDisplayNone">
          圖片       
        </th>
        <th class="FormItemObjectBox">
          操作      
        </th>
      </tr>
    </thead>
    
    <tbody>
      <tr class="FormItem ObjectBoxBoerderBottom FormItemToHover" 
        v-for="(member, index) in aboutMemberInfo" 
        :key="member.id"
      >
        <td class="FormItemObjectNumber ObjectBoxNumber ObjectToMinWidthDisplayNone">
          {{ index +1 }}
        </td>
        <td class="FormItemObjectNumber ObjectBoxNumber">
          <input 
            type="checkbox"
            :checked="Number(member.display) === 1"
            @change="toggleDisplay(member)"
          >
        </td>
        <td class="FormItemObjectBox TextAlignLeft">
          {{ member.person_name }}
        </td>
        <td class="FormItemObjectBox ObjectToMinWidthDisplayNone">
            <img 
              v-if="member.image_name" 
              v-lazy="getImagUrl(member.image_name)" 
              width="150px"
            >
            <div v-else class="errorBold">沒有添加圖片</div>
        </td>
        <td class="FormItemObjectBox ItemButtonTh">
          <div class="ItemButtonTh">
            <router-link 
              class="ItemButton ItemButtonWidthMax hidden" 
              :to="{
                path: `/BackStage/About/MemberEdit/${member.id}`,
              }"
            >
              編輯
            </router-link>
            <button @click="deleteMember(member)" class="ItemButton ItemButtonWidthMax hidden" type="button">刪除</button>
          </div>
        </td>
      </tr>
    </tbody>    
  </table>
</template>

<script>
import { eventBus } from '@/eventBus';
import { computed, inject, onMounted, onUnmounted } from 'vue';
import { useStore } from 'vuex';

export default {
  setup(){
    const store   = useStore();
    const apiUrl  = inject('apiUrl');

    //獲取vuex
    onMounted(async() =>{
      eventBus.on('AboutMemberrefreshMemberList', refreshMemberList);
      const result = await store.dispatch('AboutMemberStore/fetchDetails')
      if(!result.success) {
        eventBus.emit('sentErrorMessage', '載入失敗' + result.message);
      }
      
    })

    onUnmounted(()=>{
      eventBus.off('AboutMemberrefreshMemberList', refreshMemberList);
    })

    const aboutMemberInfo = computed(() => store.getters['AboutMemberStore/getAboutMemberStore']);

    const refreshMemberList = async() =>{
      store.commit('AboutMemberStore/CLEAR_ALL',[])
      await store.dispatch('AboutMemberStore/fetchDetails')
    }

    //獲取圖片
    const getImagUrl = (imageName) => {
      if (!imageName) return ''; // 如果圖片名稱為空，回傳空字串
      return `${apiUrl}/src/assets/about/${imageName}`;
    };

    //開選顯示
    const toggleDisplay = async (member) => {
      // ✅ 直接傳遞 `id`，讓 Vuex 負責計算新值，並且更新
      store.dispatch("AboutMemberStore/updateMemberDisplay", member.id);
    };

    //刪除處理
    const deleteMember = async (member) =>{
      if(confirm('確定要刪除這個人員嗎?')) {
        try{
          const response = await store.dispatch('AboutMemberStore/DeleteMember', member)
          if(response && response.success){
            alert('刪除成功')
          } else {
            alert('刪除失敗，請稍後再試');
          }
        } catch (error) {
          alert('刪除時發生錯誤:', error);
          console.error('刪除時發生錯誤:', error);
        }
      }
    }

    return{
      aboutMemberInfo,
      getImagUrl,
      toggleDisplay,
      deleteMember,
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