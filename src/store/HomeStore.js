import { callApi } from "@/utils/apiHelper";

export const HomeStore = (apiUrl) => ({
  namespaced: true,
  state:() =>({
    HomeBannerTitle:      '',
    HomeBannerBtn:        '',
    HomeBannerIMG:        '',
    HomeTwoTitle:         '',
    HomeThreeTitle:       '',
    HomeThreeContent:     '',
    HomeThreeBtn:         '',
    HomeThreeIMG:         '',
    LoadingCompleted:     false,
  }),

  mutations: {
    SET_HOME_STORE(state, home) {
      const {
        home_one_title,
        home_one_btn,
        home_one_image,
        home_two_title,
        home_three_title,
        home_three_content,
        home_three_btn,
        home_three_image,
      } = home;

      Object.assign(state,{
        HomeBannerTitle       : home_one_title,
        HomeBannerBtn         : home_one_btn,
        HomeBannerIMG         : home_one_image,
        HomeTwoTitle          : home_two_title,
        HomeThreeTitle        : home_three_title,
        HomeThreeContent      : home_three_content,
        HomeThreeBtn          : home_three_btn,
        HomeThreeIMG          : home_three_image,
        LoadingCompleted      : true,
      })

      
    },
    CLEAR_ALL(state){
      Object.assign(state,{
        HomeBannerTitle       : '',
        HomeBannerBtn         : '',
        HomeBannerIMG         : '',
        HomeTwoTitle          : '',
        HomeThreeTitle        : '',
        HomeThreeContent      : '',
        HomeThreeBtn          : '',
        HomeThreeIMG          : '',
        LoadingCompleted      : false,
      })     
    }
  },

  actions: {
    async fetchDetails({ commit, state }){      
        if(state.LoadingCompleted === true) return { success: true };
        const result = await callApi(
          'get', 
          `${apiUrl}/api/fetch/HomeInfoFetch.php`
        )

        if(result.success) {
          commit('SET_HOME_STORE', result.data.home);
          return { 
            success: true 
          };
        } else {
          return {
             success: false, 
             message: result.message || '更新失敗' 
            };
        }
    },

    async updateHomePage( { commit, dispatch }, formData ) {
        const result = await callApi(
          'post', 
          `${apiUrl}/api/Add&Update/HomeAdd&Update.php`, 
          formData
        )

        if(result.success) {
          commit("CLEAR_ALL");
          await dispatch("fetchDetails");
          return { 
            success: true, 
            message: result.message 
          };
        } else {
          return { 
            success: false, 
            message: result.message || '更新失敗' 
          };
        }
    }
  },

  getters: {
    getHomeStore: (state) => state,
  },
});