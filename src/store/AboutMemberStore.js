import { callApi } from "@/utils/apiHelper";

export const AboutMemberStore = (apiUrl) => ({
  namespaced: true,
  state:() =>({
    AboutMember:            [],
    LoadingCompleted:                  false,
  }),

  mutations: {
    SET_ABOUT_MEMBER_STORE(state, members) {
      state.AboutMember = Array.isArray(members) ? [...members] : [];
      state.LoadingCompleted       = true;
    },
    CLEAR_ALL(state, members) {
      state.AboutMember = Array.isArray(members) ? [...members] : [];
      state.LoadingCompleted       = false;
    },
    SET_ABOUT_MEMBER_DISPLAY(state, id) {
      state.AboutMember = state.AboutMember.map(member => 
        member.id === id ? { ...member, display: Number(member.display) === 1 ? 0 : 1 } : member
      );
    },
    REMOVE_ABOUT_MEMBER(state, id) {
      state.AboutMember = state.AboutMember.filter(member => member.id !== id);
      state.LoadingCompleted       = false;
    }
  },

  actions: {
    async fetchDetails({ commit, state}){
        if( state.LoadingCompleted === true ) return { success:true }

        const result = await callApi('get', `${apiUrl}/api/fetch/AboutMemberFetch.php`)
        
        if(result.success) {
          commit('SET_ABOUT_MEMBER_STORE', result.data.abouts);
          return {
            success:true
          }
        } else {
          return { 
            success: false, 
            message: result.message || '讀取時發生錯誤' 
          };
        }
    },
    async updateMemberDisplay({ commit, state }, id) {
      // 找到對應的 member
      const member = state.AboutMember.find(member => member.id === id);
      if (!member) {
        console.error("成員不存在，無法更新");
        return;
      }  
      // 計算新的 display 值
      const newDisplay = Number(member.display) === 1 ? 0 : 1;  

      const result = await callApi(
        'post', 
        `${apiUrl}/api/Add&Update/AboutMemberDisplayUpdate.php`,
        JSON.stringify({ id, display: newDisplay }),
        {"Content-Type": "application/json"}
      )
        
        if(result.success) {
          commit("SET_ABOUT_MEMBER_DISPLAY", id);
        } else {
          return { 
            success: false, 
            message: result.message || '更新時發生錯誤' };
        }
    },
    async DeleteMember({commit}, member){
      const id = member.id;
      const image_name = member.image_name;

      const result = await callApi(
        'post', 
        `${apiUrl}/api/Delete/AboutMemberDelete.php`,
        JSON.stringify({ id, image_name }),
        { "Content-Type": "application/json" }
      )
        
      if(result.success) {
        commit("REMOVE_ABOUT_MEMBER", id);
        return { success: true };
      } else {
        return { 
          success: false, 
          message: result.message || '更新時發生錯誤' };
      }
    }    
  },

  getters: {
    getAboutMemberStore: (state) => {
      return  state.AboutMember
    }
  },
});