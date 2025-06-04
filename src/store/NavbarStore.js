export const NavbarStore = () => ({
  namespaced: true,
  state:() =>({
    isBackStageNavbarOpen:          false,
    isBackStageNavbarOptionTwoOpen: false,
  }),

  mutations: {
  },

  actions: {
     toggleBackStageNavbar({state}){
      state.isBackStageNavbarOpen =! state.isBackStageNavbarOpen;
     },
     closeBackStageNavbar({state}){
      state.isBackStageNavbarOpen =false;
     },
     toggleBackStageNavbarOptionTwo({state}){
      state.isBackStageNavbarOptionTwoOpen =! state.isBackStageNavbarOptionTwoOpen;
     },
     closeBackStageNavbarOptionTwo({state}){
      state.isBackStageNavbarOptionTwoOpen =false;
     },
  },

  getters: {
    getBackStageNavbar: (state) =>{
      return state.isBackStageNavbarOpen;
    },
    getBackStageNavbarOptionTwo: (state) =>{
      return state.isBackStageNavbarOptionTwoOpen;
    }
  },
});