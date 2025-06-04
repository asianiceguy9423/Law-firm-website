import { callApi } from "@/utils/apiHelper";

export const ContactStore = (apiUrl) => ({
  namespaced: true,
  state:() =>({
    BannerIMG:              '',
    BannerTitle:            '',
    Title:                  '',
    InfoDetails:            [],
    LoadingBannerCompleted:            false,
    LoadingInfoCompleted:            false,
  }),

  mutations: {
    SET_CONTACT_STORE(state, contact) {
      const { image_name, banner_title, title } = contact;
      state.BannerIMG = image_name;
      state.BannerTitle = banner_title;
      state.Title = title;
      state.LoadingBannerCompleted = true;
    },
    SET_CONTACT_STORE_DETAILS(state, info) {
      state.InfoDetails           = Array.isArray(info) ? [...info] : [];
      state.LoadingInfoCompleted             = true; 
    },
    RESET_BANNERIMG_STATE(state){
      state.BannerIMG             = '';
      state.LoadingBannerCompleted             = false;
    },
    SET_CONTACT_INFO_DISPLAY(state, id){
      state.InfoDetails = state.InfoDetails.map(InfoItem => 
        InfoItem.id === id ? {...InfoItem, display: Number(InfoItem.display) === 1 ? 0 : 1} : InfoItem
      );
       state.LoadingInfoCompleted             = false;
    },
    SET_CONTACT_INFO_CLEAR(state){
      state.InfoDetails           = [];
      state.LoadingInfoCompleted             = false;
    },
    REMOVE_CONTACT_INFO(state, id){
      state.InfoDetails = state.InfoDetails.filter(Info => Info.id !== id);
    }
  },

  actions: {
    async fetchContactBanner({ state,commit }){
      if(state.LoadingBannerCompleted === true) return { success:true };

      const result = await callApi('get', `${apiUrl}/api/fetch/ContactInfoFatch.php`)

      if(result.success) {
        commit('SET_CONTACT_STORE', result.data.contact);
        return { success: true };
      } else {
        return { 
          success: false, 
          message: result?.message || '讀取時發生錯誤' 
        };
      }
    },
    async fetchContactStoreInfo({ state, commit }){
      if(state.LoadingInfoCompleted === true) return { success:true };

      const result = await callApi('get', `${apiUrl}/api/fetch/ContactStoreInfoFatch.php`);

      if(result.success) {
        commit('SET_CONTACT_STORE_DETAILS', result.data.info);
        return { success: true };
      } else {
        return { 
          success: false, 
          message: result.message 
        };
      }
    },
    async updateContactInfo({commit, dispatch},formData) {
      const result = await callApi('post',`${apiUrl}/api/Add&Update/ContactPageAdd&Update.php`,formData)

      if(result.success) {
        commit('RESET_BANNERIMG_STATE');
        await dispatch('fetchContactBanner')
        return {
          success: true, 
          message: result.message
        }
      } else {
        return {
          success: false, 
          message: result.message || '更新時發生錯誤' 
        };
      }
    },
    async updateInfoDisplay({commit, state}, {id, display}) {
        const InfoItem = state.InfoDetails.find(InfoItem => InfoItem.id === id);
      if(!InfoItem) {
        console.error("資訊列表不存在，無法更新");
        return { success: false, message: '找不到指定項目' };
      }

      const result = await callApi(
        'post',
        `${apiUrl}/api/Add&Update/ContantInfoDisplayUpdate.php`,
        JSON.stringify({id , display}),
        {"Content-Type": "application/json"}
      )

      if (result.success ) {
        commit("SET_CONTACT_INFO_DISPLAY", id);
        return { 
          success: true, 
        };
      } else {
        return { 
          success: false, 
          message: result.message || '更新失敗' 
        };
      }
    },
    async DeleteInfo({commit}, Info) {
      const id = Info.id;

      const result = await callApi(
        'post',
        `${apiUrl}/api/Delete/ContactInfoDelete.php`,
        JSON.stringify({id}),
        {"Content-Type": "application/json"}
      )

      if(result.success) {
        commit("REMOVE_CONTACT_INFO", id);
        return { 
          success: true, 
          message: result.message 
        };
      } else {
        return { 
          success: false, 
          message: result.message || '更新時發生錯誤' };
      }
    }
  },

  getters: {
    getContactStore: (state) => state,
    getContactInfo: (state) =>{
      return state.InfoDetails
    }
  },
});