import { callApi } from "@/utils/apiHelper";

export const ArticleStore = (apiUrl) => ({
  namespaced: true,
  state:() =>({
    Articles:     [],
    LoadingCompleted:    false,
  }),

  mutations: {
    SET_ARTICLES_STORE(state, articles) {
      state.Articles = Array.isArray(articles) ? [...articles] : [];
      state.LoadingCompleted       = true;
    },
    SET_ARTICLES_DISPLAY(state, id) {
      state.Articles = state.Articles.map(articlesItem => 
        articlesItem.id === id ? { ...articlesItem, display: Number(articlesItem.display) === 1 ? 0 : 1 } : articlesItem
      );
      // state.LoadingCompleted       = false;
    },
    CLEAR_ARTICELS(state) {
      state.Articles = [];
      state.LoadingCompleted       = false;
    },
    REMOVE_ARTICLE(state, id) {
      state.Articles = state.Articles.filter(item => item.id !== id);
      state.LoadingCompleted       = false;
    }
  },

  actions: {
    async fetchDetails({ state,commit }){
      if(state.LoadingCompleted === true) return{ success:true }
      
      const result = await callApi(
        'get',
        `${apiUrl}/api/fetch/ArticlesFetch.php`
      )

      if(result.success) {
        commit('SET_ARTICLES_STORE', result.data.articles);
        return { success:true };
      } else {
        return { 
          success: false, 
          message: result.message || '讀取時發生錯誤' };
      }
    },
    async updateArticlesDisplay({ commit, state }, id) {
        // 找到對應的 item
        const articlesItem = state.Articles.find(articlesItem => articlesItem.id === id);
        if (!articlesItem) {
          console.error("文章不存在，無法更新");
          return;
        }  
        // 計算新的 display 值
        const newDisplay = Number(articlesItem.display) === 1 ? 0 : 1;  

        const result = await callApi(
          'post',
          `${apiUrl}/api/Add&Update/ArticlesDisplayUpdate.php`,
          JSON.stringify({ id, display: newDisplay }),
          { "Content-Type": "application/json" }
        )

        if(result.success) {
          commit("SET_ARTICLES_DISPLAY", id);
          return { 
            success: true, 
          };
        } else {
          return { 
            success: false, 
            message: result.message || '更新時發生錯誤' };
        }
    },
    async deletArticle({commit}, item){
        const id            = item.id;
        const banner        = item.banner;
        const context_image = item.context_image;

        const result = await callApi(
          'post',
          `${apiUrl}/api/Delete/ArticleDelete.php`,
          JSON.stringify({ id, banner,  context_image}),
          { "Content-Type": "application/json" }
        )

        if(result.success) {
          commit("REMOVE_ARTICLE", id);
          return { 
            success: true, 
          };
        } else {
          return { 
            success: false, 
            message: result.message || '更新時發生錯誤' };
        }
    }
  },

  getters: {
    getArticlesStore: (state) => {
      return state.Articles;
    },
    getArticleByID: (state) => (id) => {
      return state.Articles.find(article => String(article.id) === String(id));
    }
  },
});