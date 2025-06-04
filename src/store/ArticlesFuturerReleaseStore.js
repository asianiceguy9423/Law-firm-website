import { callApi } from "@/utils/apiHelper";

export const ArticlesFuturerReleaseStore = (apiUrl) => ({
  namespaced: true,
  state:() =>({
    ArticlesFutureReleaseName:      '',
    ArticlesFutureReleaseContent:   '',
    ArticlesFutureReleaseIMG:       '',
    ArticlesFutureReleaseDisplay:   '',
    LoadingCompleted:                      false,
  }),

  mutations: {
    SET_ARTICLES_FUTURE_RELEASE_STORE(state, articles) {
      state.ArticlesFutureReleaseName       = articles.articles_future_release_name;
      state.ArticlesFutureReleaseContent    = articles.articles_future_release_content;
      state.ArticlesFutureReleaseIMG        = articles.articles_future_release_image;
      state.ArticlesFutureReleaseDisplay    = articles.articles_future_release_display;
      state.LoadingCompleted                = true;
    },
    CLEAR_STATE(state) {
      Object.assign(state,{
        ArticlesFutureReleaseName       : '',
        ArticlesFutureReleaseContent    : '',
        ArticlesFutureReleaseIMG        : '',
        ArticlesFutureReleaseDisplay    : '',
        LoadingCompleted                : false,
      })      
    },
    CLEAR_Display(state) {
      state.ArticlesFutureReleaseDisplay    = '';
      state.LoadingCompleted                = false;
    }
  },

  actions: {
    async fetchDetails({ state, commit }){
        if(state.LoadingCompleted === true) return { success: true };

        const result = await callApi(
          'get',
          `${apiUrl}/api/fetch/ArticlesFutureReleaseFetch.php`
        )

        if(result.success) {
          commit('SET_ARTICLES_FUTURE_RELEASE_STORE', result.data.articles);
          return { 
            success: true
          };
        } else {
          return { 
            success: false, 
            message: result.message || '讀取時發生錯誤' };
        }
    },
    async updateDisplay({ commit, dispatch },newDisplay){
      const result = await callApi(
        'post',
        `${apiUrl}/api/Add&Update/ArticlesFutureReleaseDisplayUpdate.php`,
        {newDisplay: Number(newDisplay)},
        { 'Content-Type': 'application/json' }
      )

      if(result.success) {
        commit("CLEAR_Display");
        await dispatch("fetchDetails");
        return { 
          success: true, 
          message: result.message 
        };
      } else {
        return { 
          success: false, 
          message: result.message || '更新時發生錯誤' };
      }
    },
    async updateArticlesPage({ commit, dispatch }, formData) {
      const result = await callApi(
        'post',
        `${apiUrl}/api/Add&Update/ArticlesFutureReleaseAdd&Update.php`,
        formData
      )

      if(result.success) {
        commit("CLEAR_STATE");
        await dispatch("fetchDetails");
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
    getArticlesFuturerReleaseStore: (state) => state,
  },
});