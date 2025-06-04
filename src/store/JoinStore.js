import { callApi } from "@/utils/apiHelper";

export const JoinStore = (apiUrl) => ({
  namespaced: true,
  state:() =>({
    JoinTitle:            '',
    JoinContent:           '',
    JoinBtn:              '',
    JoinIMG:              '',
    LoadingCompleted:     false,
  }),

  mutations: {
    SET_JOIN_STORE(state, join) {
      state.JoinTitle         = join.title;
      state.JoinContent        = join.content;
      state.JoinBtn           = join.btn_text;
      state.JoinIMG           = join.image_name;
      state.LoadingCompleted  = true;
    },
    CLEAR_ALL(state){
      Object.assign(state,{
        JoinTitle             :'',
        JoinContent            :'',
        JoinBtn               :'',
        JoinIMG               :'',
        LoadingCompleted      :false,
      })
    }
  },

  actions: {
    async fetchDetails({ state, commit }){
        if(state.LoadingCompleted === true) return { success: true };
        const result = await callApi(
          'get',
          `${apiUrl}/api/Add&Update/JoinAdd&Update.php`
        )

        if(result.success){
          commit('SET_JOIN_STORE', result.data.join);
          return {success: true}
        } else {
          return { 
            success: false, 
            message: result?.message || '更新失敗'
          };
        }
    },

    async updateJoinPage( {commit, dispatch}, formData ){
        // for(const value of formData.values()){
        //   console.log('vuex:' + value)
        // }
        const result = await callApi(
          'post',
          `${apiUrl}/api/Add&Update/JoinAdd&Update.php`,
          formData
        )

        if(result.success){
          commit("CLEAR_ALL");
          await dispatch("fetchDetails");
          return {
            success: true,
            message: result.message
          }
        } else {
          return { 
            success: false, 
            message: result.message || '更新失敗'
          };
        }
    },
  },

  getters: {
    getJoinStore: (state) => state,
  },
});