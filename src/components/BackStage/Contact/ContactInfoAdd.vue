<template>
  <div class="BK">
    <WarnMessage/>
    <div class="FlexBoxBottom PaddingLeftRight">
      <div>
        <div class="LinkButtonMarginLeft">
          <button @click="goBack" class="PointButton PointMargin" type="button">{{ navbarName }}</button>
          <svg xmlns="http://www.w3.org/2000/svg"  height="14" width="8.75" viewBox="0 0 320 512">
            <path fill="#acafc4" d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/>
          </svg>
          <button class="PointButton" type="button">新增資訊</button>
        </div>
        <h1>新增資訊</h1>
      </div>
      <div>
        <button @click="goBack" type="button" class="ItemButton ItemButtonWhite">取消</button>
        <button @click="submitContactInfoAdd" type="submit" class="ItemButton">確定新增</button>
      </div>      
    </div>

    <form @submit.prevent="submitContactInfoAdd" enctype="multipart/form-data" class="PaddingLeftRight">
      <table class="RouterPage">
        <thead class="ObjectBox ObjectBoxBoerderBottom">
          <th class="TitleH3">輸入新資訊</th>
        </thead>
        <tbody class="ObjectBox ObjectGrid">
          <tr class="ObjectItem">
            <td>項目(例如:電話):</td>
            <td>
              <input 
                class="InputText"
                type="text" 
                v-model="project" 
                placeholder="這邊輸入項目" 
              >
            </td>
          </tr>
          <tr class="ObjectItem">
            <td>說明(例如:09-xxxxx)</td>
            <td>
              <input 
                class="InputText"
                type="text" 
                v-model="explain" 
                placeholder="這邊輸入說明" 
                >
            </td>
          </tr>
        </tbody>
      </table>
    </form>
  </div>
</template>

<script>
import { computed, inject, onMounted, ref } from 'vue';
import WarnMessage from '../WarnMessage.vue';
import { useStore } from 'vuex';
import axios from 'axios';
import { eventBus } from '@/eventBus';
import { useRouter } from 'vue-router';

export default {
  components:{
    WarnMessage,
  },
  setup(){
    const project = ref('');
    const explain = ref('');
    const router  = useRouter();
    const store   = useStore();
    const apiUrl  = inject('apiUrl');

    onMounted(()=>{
      window.scroll(0, 0);
    })

    const navbarName = computed(()=> store.getters['WebsiteInformation/getNavbarFourName']);

    const goBack = () =>{
      router.go(-1);
    };

    const buildFormData = () =>{
      const formData = new FormData();
      formData.append('project', project.value);
      formData.append('explain', explain.value);
      return  formData;
    }

    const submitContactInfoAdd = async () =>{
      const formData = buildFormData();
      if (!project.value.trim() || !explain.value.trim()) {
        eventBus.emit('sentErrorMessage', '請完整填寫項目與說明');
        return;
      }
      try{
        const response = await axios.post(`${apiUrl}/api/Add&Update/ContactInfoAdd.php`, formData);
        const data = response.data;

        if(data.success) {
          store.commit('ContactStore/SET_CONTACT_INFO_CLEAR');
          await store.dispatch("ContactStore/fetchContactStoreInfo");

          localStorage.setItem('successMessage', `${data.message}`);
          router.push('/BackStage/Contact');
        } else {
          eventBus.emit('sentErrorMessage', data.message);
        }
      } catch (error) {
        eventBus.emit('sentErrorMessage', error.message || '提交失敗，請稍後再試');
      } finally {
        window.scroll(0, 0);
      }
    }

    return{
      project,
      explain,
      goBack,
      submitContactInfoAdd,
      navbarName,
    }
  }
}
</script>

<style>
</style>