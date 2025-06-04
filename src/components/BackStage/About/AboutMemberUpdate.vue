<template>
  <div class="BK">
    <WarnMessage/>
    <IsLoading v-show="isLoading"/>
    <div class="FlexBoxBottom PaddingLeftRight">
      <div>
        <div class="LinkButtonMarginLeft">
          <button @click="goBack" class="PointButton PointMargin" type="button">{{ navbarName }}</button>
          <svg xmlns="http://www.w3.org/2000/svg"  height="14" width="8.75" viewBox="0 0 320 512">
            <path fill="#acafc4" d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/>
          </svg>
          <button class="PointButton" type="button">編輯人員</button>
        </div>
        <h1>編輯人員</h1>
      </div>
      <div>
        <button @click="goBack" type="button" class="ItemButton ItemButtonWhite">取消</button>
        <button @click="submitAboutMemberAdd" type="submit" class="ItemButton">確定更新</button>
      </div>
    </div>

    <form @submit.prevent="submitAboutMemberAdd" enctype="multipart/form-data" class="PaddingLeftRight">
      <table class="RouterPage">
        <thead>
          <tr class="ObjectBox ObjectBoxBoerderBottom">
            <th colspan="2" class="TitleH3">
              輸入資訊
            </th>            
          </tr>
        </thead>
        
        <tbody class="ObjectBox ObjectGrid">
          <tr class="ObjectItem">
            <td>個人圖片</td>
            <td>
              <div>
                <img v-if="IMGUrl" :src="IMGUrl" width="150px">
                <div v-else class="error">尚未上傳個人照片</div>
              </div>
              <div>
                <input
                  class="fileInput" 
                  type="file" 
                  id="fileMemberPersonIMGAddInput"
                  @change="handleFileUpload"
                >
                <label 
                  class="ItemButton"
                  type="button"
                  for="fileMemberPersonIMGAddInput"
                >
                  選擇圖片
                </label>
                <div class="Font14">
                  {{ fileName || '尚未更換圖片' }}
                </div>
              </div>
            </td>
          </tr>
          <tr class="ObjectItem">
            <td>人名</td>
            <td>
              <input 
                class="InputText"
                type="text" 
                v-model="localPersonName" 
                placeholder="這邊輸入人名" 
              >
            </td>
          </tr>
          <tr class="ObjectItem">
            <td>職位</td>
            <td>
              <input 
                class="InputText"
                type="text" 
                v-model="localPosition" 
                placeholder="這邊輸入職位" 
                >
            </td>
          </tr>
          <tr class="ObjectItem">
            <td>專長</td>
            <td>
              <textarea 
                class="InputText"
                v-model="localSkill" 
                placeholder="這邊輸入專長" 
              ></textarea>
            </td>            
          </tr>
          <tr class="ObjectItem">
            <td>經歷</td>
            <td>
              <textarea 
              class="InputText"
              v-model="localIntroduction" 
              placeholder="這邊書如經歷" 
            ></textarea>
            </td>            
          </tr>
        </tbody>
      </table>
    </form>
  </div>
</template>

<script>
import { eventBus } from '@/eventBus';
import axios from 'axios';
import { computed, inject, nextTick, onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import WarnMessage from '../WarnMessage.vue';
import IsLoading from '../IsLoading.vue';
import { useStore } from 'vuex';

export default {
  components:{
    IsLoading,
    WarnMessage,
  },
  props :{
    id:String,
  },
  setup(props){      
    const localPersonName     =  ref('');
    const localPosition       = ref('');
    const localSkill          = ref('');
    const localIntroduction   = ref('');
    const localImageName      = ref('');
    const selectedImage       = ref(null);
    const fileName            = ref('');
    const router              = useRouter();
    const apiUrl              = inject('apiUrl');
    const isLoading           = ref(true);
    const store               = useStore();

    onMounted(async() => {
      const result = await store.dispatch('AboutMemberStore/fetchDetails');
      if(!result.success){
        eventBus.emit('sentErrorMessage', '載入失敗' + result.message);
      }
      const memberInfo = computed(() =>{
        return allMemeberInfo.value.find(item => item.id === props.id);
      })  
      if(memberInfo.value){
        localPersonName.value = memberInfo.value.person_name;
        localPosition.value = memberInfo.value.position;
        localSkill.value = memberInfo.value.skill;
        localIntroduction.value = memberInfo.value.introduction;
        localImageName.value = memberInfo.value.image_name;
      }
      isLoading.value = false;
      window.scroll(0, 0);
    });

    const allMemeberInfo = computed(()=> store.getters['AboutMemberStore/getAboutMemberStore'])
    const navbarName = computed(()=> store.getters['WebsiteInformation/getNavbarOneName']);

    //獲取圖片
      const IMGUrl = computed(() =>
      localImageName.value
      ?`${apiUrl}/src/assets/about/${localImageName.value}`
      :''
    );

    //處理圖片上傳
    const handleFileUpload = (event) =>{
      selectedImage.value = event.target.files[0];
      fileName.value  = selectedImage.value ? selectedImage.value.name : '';
    }

    const goBack = () =>{
      router.go(-1);
    }

    const buildFormData = () =>{
      const formData = new FormData();
      formData.append('id', props.id);
      formData.append('person_name', localPersonName.value);
      formData.append('position', localPosition.value);
      formData.append('skill', localSkill.value);
      formData.append('introduction', localIntroduction.value);
      if (selectedImage.value) formData.append('image', selectedImage.value);
      return formData;
    }

    const submitAboutMemberAdd = async () => {
      try {
        const formData = buildFormData();
        if (
        !localPersonName.value.trim() || 
        !localPosition.value.trim() ||
        !localSkill.value.trim() || 
        !localIntroduction.value.trim()
      ) {
        eventBus.emit('sentErrorMessage', '請完整填寫項目與說明');
        return;
      }
        // 這裡要用 `await` 等待 API 回應
        const response = await axios.post(`${apiUrl}/api/Add&Update/AboutMemberUpdate.php`, formData);
        const data = response.data;

        if (data.success) {
          // 將成功訊息暫存
          localStorage.setItem('successMessage', `${data.message}`);
          // 跳轉回 About 頁面
          router.push('/BackStage/About').then(()=>{
            nextTick(()=>{
              eventBus.emit('AboutMemberrefreshMemberList')
            })
          });
        } else {
          eventBus.emit('sentErrorMessage', `${data.message}`);
        }
      } catch (error) {
        eventBus.emit('sentErrorMessage', error?.message || '發生未知錯誤');
      }

      window.scroll(0, 0);
    };

    return{
      localPersonName,
      localPosition,
      localSkill,
      localIntroduction,
      IMGUrl,
      fileName,
      isLoading,
      handleFileUpload,
      goBack,
      submitAboutMemberAdd,
      navbarName,
    }
  }
}
</script>

<style>

</style>