import { callApi } from "@/utils/apiHelper";

export const AboutStore = (apiUrl) => ({
  namespaced: true,
  state:() =>({
    AboutBannerTitle:           {},
    AboutBannerIMG:             '',
    AboutTwoTitle:              '',
    AboutTwoContent:            '',
    AboutPersonIMG:             '',
    AboutThreeBKIMG:            '',
    LoadingCompleted:           false,
  }),

  mutations: {
    SET_ABOUT_STORE(state, about) {
      const {
        about_one_title,
        about_one_image,
        about_two_title,
        about_two_writings,
        about_two_image,
        about_three_BK,
      } = about;

      state.AboutBannerTitle        = typeof about_one_title === 'object'
        ? about.about_one_title
        : {};

      Object.assign(state,{
        AboutBannerIMG          : about_one_image,
        AboutTwoTitle           : about_two_title,
        AboutTwoContent         : about_two_writings,
        AboutPersonIMG          : about_two_image,
        AboutThreeBKIMG         : about_three_BK,
        LoadingCompleted        : true,
      })
      
    },
    CLEAR_All(state) {
      Object.assign(state,{
        AboutBannerTitle      : {},
        AboutBannerIMG        : '',
        AboutTwoTitle         : '',
        AboutTwoContent       : '',
        AboutPersonIMG        : '',
        AboutThreeBKIMG       : '',
        LoadingCompleted      : false,
      })      
    }
  },

  actions: {
    async fetchDetails({ state,commit }){
      if(state.LoadingCompleted === true) return { success:true };

      const result = await callApi(
        'get',
        `${apiUrl}/api/fetch/AboutInfoFetch.php`
      )

      if(result.success) {
        commit('SET_ABOUT_STORE', result.data.about);
        return { 
          success: true, 
        };
      } else {
        return { 
          success: false, 
          message: result.message || '讀取時發生錯誤' };
      }
    },
    async updateAboutPage({ commit, dispatch }, formData) {
      const result = await callApi(
        'post', 
        `${apiUrl}/api/Add&Update/AboutPageAdd&Update.php`, formData
      )

      if(result.success) {
        commit("CLEAR_All");
          await dispatch("fetchDetails");
          return { 
            success: true, 
            message: result.message 
          };
      } else {
        return { 
          success: false, 
          message: result.message || '更新時發生錯誤' 
        };
      }
    } 
  },

  getters: {
    getAboutStore: (state) => state,
  },
});