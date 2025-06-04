<template>
  <div class="BK">
    <WarnMessage/>
    <IsLoading v-show="isLoading"/>

    <div v-show="!isLoading" class="ObjectBoxFlex PaddingLeftRight">
      <h1>後臺管理</h1>
    </div>

    <div v-show="!isLoading" class="PaddingLeftRight PaddingBottom">
      <form 
        @submit.prevent="submitForm" 
        enctype="multipart/form-data" 
        class="formGrid"
      >
        <table class="RouterPage">
          <thead>
            <tr class="ObjectBox ObjectBoxBoerderBottom ObjectBoxFlex PaddingLeftRight">
              <th class="TitleH3">
                使用者資訊
              </th>
              <th class="ItemButtonTh">
                <router-link  to="/BackStage/UserData/CheckPassword">
                  <button class="ItemButton">變更密碼</button>
                </router-link>
              </th>
          </tr>
          </thead>
          <tbody>
            <tr class="FormItem ObjectBox">
              <td>
                當前帳號: {{ UserDataInfo.Username }}
              </td>          
            </tr>
          </tbody>     
        </table>
      </form>
    </div>
  </div>
</template>

<script>
import { computed, onMounted, ref } from 'vue';
import IsLoading from '../IsLoading.vue';
import WarnMessage from '../WarnMessage.vue';
import { useStore } from 'vuex';
import { eventBus } from '@/eventBus';

export default {
  components:{
    WarnMessage,
    IsLoading,
  },
  setup(){
    const isLoading = ref(true);
    const store = useStore();
    
    onMounted(async () => {
      const result = await store.dispatch('UserLoginStore/fetchDeatils');
      if(!result.success) {
        eventBus.emit('sentErrorMessage', '載入失敗' + result.message);
      }
      isLoading.value = false;
      window.scroll(0, 0);
    })

    const UserDataInfo = computed(() => store.getters['UserLoginStore/getUserStore']);

    return {
      isLoading,
      UserDataInfo,

    }
  }
}
</script>

<style>

</style>