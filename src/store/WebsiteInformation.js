import { callApi } from '@/utils/apiHelper';

export const WebsiteInformation = (apiUrl) => ({
  namespaced: true, // 啟用命名空間
  state: () => ({
    currentLOGO:          '',
    colorChart:           [],
    navbarMainOption:     [],
    navbarOptions:        [],
    storeInfo:            [],
    LinkInfo:             [],
    mainColor:            '',
    secondaryColor:       '',
    thirdColor:           '',
    fourthColor:          '',
    LoadingCompleted:            false, //判斷是否已加載
  }),

  mutations: {
    SET_WEBSITE_INFORMATION(state, payload) {
      const {
        basic_logo,
        basic_color,
        basic_navbar_main_option,
        basic_navbarOptions,
        basic_store_Info,
        basic_link_Info,
      } = payload;

      state.currentLOGO           = basic_logo;
      state.colorChart            = Array.isArray(basic_color) ? basic_color : [];
      state.mainColor             = state.colorChart.find(color => color.name === 'mainColor')?.color || '214, 185, 105';
      state.secondaryColor        = state.colorChart.find(color => color.name === 'secondaryColor')?.color || '255, 255, 255';
      state.thirdColor            = state.colorChart.find(color => color.name === 'thirdColor')?.color || '71, 71, 71';
      state.fourthColor           = state.colorChart.find(color => color.name === 'fourthColor')?.color || '0, 0, 0';
      state.navbarMainOption      = Array.isArray(basic_navbar_main_option) ? basic_navbar_main_option : [];
      state.navbarOptions         = Array.isArray(basic_navbarOptions) ? basic_navbarOptions : [];
      state.storeInfo             = Array.isArray(basic_store_Info) ? basic_store_Info : [];
      state.LinkInfo              = Array.isArray(basic_link_Info) ? basic_link_Info : [];
      state.LoadingCompleted             = true;
    },
    RESET_COLOR_STATE(state){
      state.currentLOGO     =   '';
      state.LoadingCompleted       =   false;
    },
    RESET_LOGO_STATE(state){
      state.colorChart      =   [];
      state.mainColor       =   '';
      state.secondaryColor  =   '';
      state.thirdColor      =   '';
      state.fourthColor     =   '';
      state.LoadingCompleted       =   false;
    },
    SET_NAVBAR_MAIN_OPTION(state, updatedNavbar) {
      state.navbarMainOption = updatedNavbar;
      state.LoadingCompleted       =   false;
    },
    SET_STORE_INFO(state, updatedStoreInfo) {
      state.storeInfo = updatedStoreInfo;
      state.LoadingCompleted       =   false;
    },
    SET_STORE_LINK(state, updatedStoreLink) {
      state.LinkInfo = updatedStoreLink;
      state.LoadingCompleted       =   false;
    },
    SET_ARTICLE_OPTION_DISPLAY(state, updateOptionDisplay) {
      state.navbarOptions = updateOptionDisplay;
      state.LoadingCompleted       =   false;
    },
    CLEAR_ARTICLE_OPTION(state){
      state.navbarOptions   =   [];
      state.LoadingCompleted       =   false;
    }
  },

  actions: {
    async fetchDetails({ commit, state }) {
      if(state.LoadingCompleted === true) return { success:true }; 
       const result = await callApi(
        'get',
        `${apiUrl}/api/fetch/BasicInfoFetch.php`
       )

       if(result.success) {
        commit('SET_WEBSITE_INFORMATION', result.data.basic);
        return { success: true };
       } else {
        return { success: false, message: result.message || '更新失敗' };
       }
    },

    async updateColor(_, formData) {
      const result = await callApi(
        'post', 
        `${apiUrl}/api/Add&Update/BasicInfoColorUpdate.php`,
        formData
      )

      if(result.success) {
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
    },

    async updateNavbarDisplay({ state, commit }, { number, newDisplay }) {
      const updatedNavbar = state.navbarMainOption.map(item =>
        item.number === number ? { ...item, display: newDisplay } : item
      );
  
      commit('SET_NAVBAR_MAIN_OPTION', updatedNavbar);

      const result = await callApi(
        'post', 
        `${apiUrl}/api/Add&Update/BasicInfoNavbarMainOptionDisplayUpdate.php`,
        updatedNavbar, 
        { "Content-Type": "application/json" }
      )

      if(result.success) {
        return { success: true };
      } else {
        return { 
          success: false, 
          message: result.message || '更新失敗' 
        };
      }
    },

    async updateBasicInfo(_, formData) {
      const result = await callApi(
        'post', 
        `${apiUrl}/api/Add&Update/BasicInfoUpdate.php`,
        formData
      )

      if(result.success) {
         return { 
          success: true, 
          message: result.message 
        };         
      } else {
        return { 
          success: false, 
          message: result?.message || '更新失敗' 
        };         
      }
    },

    async updatStoreInfoDisplay({ state, commit }, { name, newDisplay }) {
      const updatedStoreInfo = state.storeInfo.map(item =>
        item.name === name ? { ...item, display: newDisplay } : item
      );
      commit('SET_STORE_INFO', updatedStoreInfo);

      const result = await callApi(
        'post', 
        `${apiUrl}/api/Add&Update/BasicStoreInfoDisplayUpdate.php`,
        updatedStoreInfo,
        { "Content-Type": "application/json" }
      )

      if(result.success) {
        return { success: true };
      } else {
        return { 
          success: false, 
          message: result?.message || '更新失敗' 
        };
      }
    },

    async updatStoreLinkDisplay({ state, commit }, { name, newDisplay }) {
      const updatedStoreLink = state.LinkInfo.map(item =>
        item.name === name ? { ...item, display: newDisplay } : item
      );
      commit('SET_STORE_LINK', updatedStoreLink);

      const result = await callApi(
        'post', 
        `${apiUrl}/api/Add&Update/BasicStoreLinkDisplayUpdate.php`,
        updatedStoreLink,
        { "Content-Type": "application/json" }
      )

      if(result.success) {
        return { success: true };
      } else {
        return { 
          success: false, 
          message: result?.message || '更新失敗' 
        };
      }
    },
    async updateArticleOptionDisplay({state,commit}, {number, newDisplay}){
      const updateOptionDisplay = state.navbarOptions.map(item =>
        item.number === number ? {...item, display: newDisplay} :item
      );
      commit('SET_ARTICLE_OPTION_DISPLAY', updateOptionDisplay);

      const result = await callApi(
        'post', 
        `${apiUrl}/api/Add&Update/ArticleOptionDisplayUpdate.php`,
        updateOptionDisplay,
        { "Content-Type": "application/json" }
      )

      if(result.success) {
        return { success: true };
      } else {
        return { 
          success: false, 
          message: result?.message || '更新失敗' 
        };
      }
    },
    async ArticleOptionUpdate({state, commit, dispatch},{number, name, explain, bannerIMG, homeIMG}){
      let oldBanner = '';
      let oldIMG = '';
      const updateOptions = state.navbarOptions.map( item => {
        if(item.number === number) {
          oldBanner = item.banner; // 👉 這裡先抓舊的
          oldIMG = item.img;
          return {
            ...item,
            name,
            explain,
            banner: bannerIMG ? bannerIMG.name : item.banner, // ✅ 僅在有圖檔時更新
            img: homeIMG ? homeIMG.name : item.img,
          };
        }
        return item;
      });

      if(JSON.stringify(updateOptions) === JSON.stringify(state.navbarOptions)){
        return{
          success: false,
          message: '沒做任何沒有更改',
        }
      }

      const buildArticleOptionUpdateFormData = () =>{
        const formData = new FormData();
        formData.append('updateOptions', JSON.stringify(updateOptions, null, 2));
        formData.append('number', number);
        formData.append('oldBanner', oldBanner);
        formData.append('oldIMG', oldIMG);
        if (bannerIMG) formData.append('bannerIMG', bannerIMG); 
        if (homeIMG) formData.append('homeIMG', homeIMG);
        return formData ;
      }
      const formData = buildArticleOptionUpdateFormData();

      const result = await callApi(
        'post', 
        `${apiUrl}/api/Add&Update/ArticleOptionUpdate.php`,
        formData
      )

      if(result.success) {
        commit('CLEAR_ARTICLE_OPTION');
        await dispatch('fetchDetails'); 
        return result.data;
      } else {
        return result.data;
      }
    }
  },

  getters: {
    getWebsiteInformations: (state) => state,
    getStoreInformations: (state) => {
      return {
        storeInfo:    state.storeInfo,
        LinkInfo:     state.LinkInfo,
        currentLOGO:  state.currentLOGO,
      }
    },
    getStoreLinkInfo: (state) => {
      return state.LinkInfo;
    },
    getNavbarOneName: (state) => {
      const item = state.navbarMainOption.find(info => info.number === "one");
      return item ? item.name : "";
    },
    getNavbarTwoName: (state) => {
      const item = state.navbarMainOption.find(info => info.number === "two");
      return item ? item.name : "";
    },
    getNavbarThreeName: (state) => {
      const item = state.navbarMainOption.find(info => info.number === "three");
      return item ? item.name : "";
    },
    getNavbarFourName: (state) => {
      const item = state.navbarMainOption.find(info => info.number === "four");
      return item ? item.name : "";
    },
    getNavbarOption: (state) =>{
      return state.navbarOptions;
    },
    getColor: (state) => {
      return {
        mainColor:          state.mainColor,
        secondaryColor:     state.secondaryColor,
        thirdColor:         state.thirdColor,
        fourthColor:        state.fourthColor,
      }
    },
  },
});
