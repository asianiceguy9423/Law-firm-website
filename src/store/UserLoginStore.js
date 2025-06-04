import { callApi } from "@/utils/apiHelper";
import axios from "axios";

export const UserLoginStore = (apiUrl) => ({
  namespaced: true,
  state:() =>({
    Username:       '',
    LoadingCompleted:            false,
  }),

  mutations: {
    SET_USER_STORE(state, user) {
      state.Username              = user.username	;
      state.LoadingCompleted      = true;
    }
  },

  actions: {
    async login(context, payload) {
      try {
        const formData = new FormData();
        formData.append('username', payload.username);
        formData.append('password', payload.password);
    
        const response = await axios.post(`${apiUrl}/api/Login.php`, formData, {
          headers: { 'Content-Type': 'multipart/form-data' }
        });
    
        const data = response.data;
    
        if (data.success) {
          context.commit('SET_USER_STORE', { username: payload.username });
          //設置cookie
          document.cookie = `sessionId=${data.sessionId}; path=/; max-age=${7 * 24 * 60 * 60}`;
          return { success: true };
        } else {
          return { success: false, message: data.message };
        }
      } catch (error) {
        console.error("Login Error:", error);
        if (error.response) {
          const status = error.response.status;
          const messages = {
            401: '密碼錯誤，請重新嘗試',
            404: '帳號不存在，請確認您的帳號',
            400: '請輸入帳號和密碼',
          };
          return { success: false, message: messages[status] || '登入時發生錯誤，請檢察網路連線' };
        }
        return { success: false, message: '無法連接伺服器，請稍後再試' };
      }
    },
    async fetchDeatils({commit, state}) {
      if( state.LoadingCompleted === true ) return { success:true }

      const result  = await callApi(
        'get',
        `${apiUrl}/api/fetch/UserDataFetch.php`,
      )

      if(result.success) {
        commit('SET_USER_STORE', result.data.userdata);
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
  },

  getters: {
    getUserStore: (state) => state,
  },
});