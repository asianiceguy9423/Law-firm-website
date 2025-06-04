<template>
  <div class="BK">
    <WarnMessage/>
    <IsLoading  v-show="isLoading"/>
    <div class="FlexBoxBottom PaddingLeftRight">
      <div>
        <div class="LinkButtonMarginLeft">
          <button @click="goBack" class="PointButton PointMargin" type="button">{{ navbarName }}</button>
          <svg xmlns="http://www.w3.org/2000/svg"  height="14" width="8.75" viewBox="0 0 320 512">
            <path fill="#acafc4" d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/>
          </svg>
          <button class="PointButton" type="button">編輯資訊</button>
        </div>
        <h1>編輯資訊</h1>
      </div>
      <div>
        <button @click="goBack" type="button" class="ItemButton ItemButtonWhite">取消</button>
        <button @click="submitAboutMemberEdite" type="submit" class="ItemButton">確定更新</button>
      </div>
    </div>

    <form 
      @submit.prevent="submitAboutMemberEdite" 
      enctype="multipart/form-data" 
      class="PaddingLeftRight"
    >
      <table class="RouterPage">
        <thead class="ObjectBox ObjectBoxBoerderBottom">
          <th class="TitleH3">編輯資訊列</th>
        </thead>
        <tbody class="ObjectBox ObjectGrid">
          <tr class="ObjectItem">
            <td>項目(例如:電話):</td>
            <td>
              <input 
                class="InputText"
                type="text" 
                v-model="localProject" 
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
                v-model="localExplainProject" 
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
import IsLoading from '../IsLoading.vue';
import WarnMessage from '../WarnMessage.vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import { useStore } from 'vuex';
import { eventBus } from '@/eventBus';

export default {
  components:{
    WarnMessage,
    IsLoading,
  },
  props:{
    id:String,
  },
  setup(props){
    const isLoading             = ref(true);
    const store                 = useStore();
    const router                = useRouter();
    const apiUrl                = inject('apiUrl');
    const localProject          = ref('');
    const localExplainProject   = ref('');

    onMounted(async() =>{
      const result = await store.dispatch('ContactStore/fetchContactStoreInfo');
      if(!result.success) {
        eventBus.emit('sentErrorMessage', '載入失敗' + result.message);
      }
      const contactInfo = computed(() =>{
        return allContactInfo.value.find(item => item.id === props.id);
      })
      if(contactInfo.value) {
        localProject.value  = contactInfo.value.project;
        localExplainProject.value = contactInfo.value.explain_project;
      }      
      isLoading.value = false;
      window.scroll(0, 0);
    })

    const allContactInfo = computed(() => store.getters['ContactStore/getContactInfo'])

    const goBack =() =>{
      router.go(-1);
    };


    const navbarName = computed(()=> store.getters['WebsiteInformation/getNavbarFourName']);

    const buildFormData = () =>{
      const formData  = new FormData();
      formData.append('id', props.id);
      formData.append('project', localProject.value);
      formData.append('explain', localExplainProject.value);
      return formData;
    }

    const submitAboutMemberEdite = async() =>{
      const formData = buildFormData();
      if(!localProject.value.trim() || !localExplainProject.value.trim()) {
        eventBus.emit('sentErrorMessage', '請完整填寫項目與說明');
        return;
      }

      const response  = await axios.post(`${apiUrl}/api/Add&Update/ContactInfoUpdate.php`, formData);
      const data= response.data;
      
      try{
        if(data.success) {
          store.commit('ContactStore/SET_CONTACT_INFO_CLEAR');
          await store.dispatch("ContactStore/fetchContactStoreInfo");

          localStorage.setItem('successMessage', `${data.message}`);
          router.push('/BackStage/Contact');
        } else {
          eventBus.emit('sentErrorMessage', `${data.message}`);
        }
      } catch (error) {
        eventBus.emit('sentErrorMessage', `${error}`);
      }finally {
        window.scroll(0, 0);    
      }
    }

    return {
      isLoading,
      localProject,
      localExplainProject,
      goBack,
      submitAboutMemberEdite,
      navbarName,
    }
  }
}
</script>

<style>
</style>