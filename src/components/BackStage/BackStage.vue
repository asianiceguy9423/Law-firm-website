<template>
  <div class="container">
    <Navbar
      :navbarMainOption = "websiteInfo.navbarMainOption"
    />
    <div class="router_div">
      <SidebarTop/>
      <router-view/>
    </div>
  </div>
</template>

<script>
import { useStore } from 'vuex';
import Navbar from './Navbar/Navbar.vue';
import SidebarTop from './Navbar/SidebarTop.vue';
import { computed, inject, onMounted } from 'vue';
import router from '@/router';
import axios from 'axios';

export default {
  components:{
    Navbar,
    SidebarTop,
  },
  setup(){
    const store = useStore();
    const apiUrl = inject('apiUrl');

    //獲取vuex
    onMounted(() => {
      store.dispatch('WebsiteInformation/fetchDetails');
    });
    const websiteInfo = computed(() => store.getters['WebsiteInformation/getWebsiteInformations']);    

    //發送發送 sessionId 進行後端驗證
    function getSessionId() {
      const cookies = document.cookie.split('; ');
      for (let cookie of cookies) {
        const [key, value] = cookie.split('=');
        if (key === 'sessionId') return value;
      }
      return null;
    }

    // 驗證 sessionId
    onMounted(async () => {
      const sessionId = getSessionId();

      console.log("當前 Session ID:", sessionId);

      if (!sessionId) {
        console.warn('沒有sessionId，未登入，重新導向 Login');
        router.push('/Login');
        return;
      }

      try {
        const response = await axios.post(
          `${apiUrl}/api/ChecksessionID.php`,
          new URLSearchParams({ sessionId }),
          {
            withCredentials: true
          } 
        );

        console.log("後端回應:", response.data);

        if (!response.data.success) {
          console.warn('Session 過期或無效，重導向 Login');
          router.push('/Login');
        }
      } catch (error) {
        console.warn('Session 驗證失敗', error);
        router.push('/Login');
      }
    });

    return{
      websiteInfo,
    }
  }
}
</script>

<style lang="scss" scoped>
::v-deep .labelDiv {
  display: flex;
  gap: 10px;
  align-items: center;
}
::v-deep .basicObject {
  white-space: nowrap;
  width: 100px;
}
::v-deep .BK {
  background: #eceff3;
  min-height: 100vh;
}
::v-deep a {
  text-decoration: none;
  color: inherit;
}
::v-deep img {
  width: 150px;
  height: 100px;
  object-fit: cover;
}
::v-deep h1{
  font-size: 28px;
}
::v-deep textarea{
  height: 350px;
}
::v-deep .error {
  color: red;
}
::v-deep .errorBold {
  color: red;
  font-weight: bold;
}
::v-deep .container {
  display: flex;
  box-sizing: border-box;
}
::v-deep .router_div{
  padding-left: 240px;
  width: 100%;
  box-sizing: border-box;
}
::v-deep .RouterPage{
  background-color: white;
  border-radius: 8px;
  width: 100%;
}
::v-deep .ObjectBox{
  display: flex;
  padding: 18px 24px;
}
::v-deep .ObjectBoxNumber{
  width: 300px;
  font-weight: bold;
}
::v-deep .ObjectBoxBoerderBottom{
  border-bottom: 2px solid #eceff3;
}
::v-deep .ObjectBoxFlex{
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 25px 0;
}
::v-deep .FlexBoxBottom{
  display: flex;
  justify-content: space-between;
  align-items: end;
  padding: 25px 0;
}
::v-deep .PaddingLeftRight{
  padding-left: 25px;
  padding-right: 25px;
  padding-bottom: 25px;
  width: 100%;
  box-sizing: border-box;
}
::v-deep .PaddingBottom{
  padding-bottom: 25px;
}
::v-deep .formGrid{
  display: grid;
  grid-gap: 18px;
}
::v-deep .TitleH3{
  font-size: 18px;
  font-weight: normal;
}
::v-deep .ObjectItem{
  display: grid;
  grid-gap: 6px;
}
::v-deep .InputText{
  font-size: 16px;
  padding: 5px 9px 5px 12px;
  border: 1.5px solid #dfe5eb;
  border-radius: 6px;
  width: 100%; 
  box-sizing: border-box;
}
::v-deep .ObjectGrid{
  display: grid;
  grid-gap: 16px;
}
::v-deep .FormItem{
  display: flex;
  align-items: center;
}
::v-deep .FormItemToHover:hover{
  background: #e7f0ff;
  cursor: pointer;
}
::v-deep .BackColorBlue{
  background: #d6e6fe;
}
::v-deep .ItemButton{
  background-color: #5999ff;
  color: #ffff;
  font-size: 16px;
  padding: 6px 24px;
  border: none;
  border-radius: 40px;
  cursor: pointer;
  display: inline-block;
  transition: 0.2s;
}
::v-deep .ItemButtonWidthMax{
  flex-grow: 0.6;
}
::v-deep .ItemButton:hover{
  background-color: #116dff;
}
::v-deep .ItemButtonWhite{
  background-color: #ffff;
  color: #5999ff;
  border: 1px solid #d6e6fe;
  margin-right: 16px;
}
::v-deep .ItemButtonTh{
  display: flex;
  flex-wrap: wrap;
  gap: 12px;  
}
::v-deep .Lawbutton{
  background-color: #ffff;
  color: #162d3d;
  border: 1px solid #162d3d;
  font-size: 14px;
  padding: 6px 16px;  
}
::v-deep .Lawbutton:hover{
  background-color: #cfd1dc;
}
::v-deep .hidden,
::v-deep .fileInput {
  display: none;
}
::v-deep .FormItemToHover:hover .ItemButton {
  display: inline-block;
}
::v-deep .Font14{
  font-size: 14px;
  color: #5999ff;;
}
::v-deep .TextAlignLeft{
  text-align: left;
  font-weight: bold;
}
::v-deep .MarginRight12{
  margin-right: 12px;
}
::v-deep .PointButton{
  border: none;
  border-radius: 40px;
  padding: 4px 8px;
  font-size: 14px;
  cursor: pointer;
  transition: 0.3s;
}
::v-deep .PointButton:hover{
  background-color: #ffffff;
}
::v-deep .SuccessColor{
  background-color: #51b77b;
}
::v-deep .ErrorColor{
  background-color: #b75151;
}

::v-deep table {
  width: 100%;
  border-collapse: collapse;
}
::v-deep td {
  width: 100%;
}
::v-deep .success-enter-active,
::v-deep .success-leave-active {
  transition: all 0.5s;
}

::v-deep .success-enter {
  transform: translateY(-100%);
  opacity: 0;
}
::v-deep .success-enter-to {
  transform: translateY(0);
  opacity: 1;
}
::v-deep .success-leave {
  transform: translateY(0);
  opacity: 1;
}

::v-deep .success-leave-to {
  transform: translateY(-100%);
  opacity: 0;
}
::v-deep .LinkButtonMarginLeft{
  margin-left: -8px;
  margin-bottom: 4px;
}
::v-deep .ActiveLawBtn{
  background-color: #162d3d;
  color: #ffff;
  transition: background-color 0.2s;
}
::v-deep .ActiveLawBtn:hover{
  background-color: #5f6375;
}
::v-deep td{
 font-size: 16px;
}
@media(max-width:1024px){
  ::v-deep .router_div{
    padding-left: 0;
  }
  ::v-deep .sidebarTop{
    display: flex;
  }
  ::v-deep .hidden {
    display: inline-block;
  }
  ::v-deep .ObjectBoxFlex{
    padding: 20px 0;
  }
  ::v-deep .PaddingLeftRight{
    padding-left: 20px;
    padding-right: 20px;
    padding-bottom: 20px;  
  }
  ::v-deep .ObjectBox{
    padding: 16px 20px;
  }
  ::v-deep .formGrid{
    grid-gap: 16px;
  }
}
@media (max-width:768px) {
  ::v-deep .ObjectToMinWidthDisplayNone{
    display: none;
  }
  ::v-deep .ObjectBoxFlex{
    padding: 12px 0;
  }
  ::v-deep .PaddingLeftRight{
    padding-left: 12px;
    padding-right: 12px;
    padding-bottom: 12px;  
  }
  ::v-deep .ObjectBox{
    padding: 12px 12px;
  }
  ::v-deep .formGrid{
    grid-gap: 8px;
  }
  ::v-deep .ObjectBoxNumber{
    width: 50px;
  }
}
@media (max-width:500px) {
  ::v-deep .ItemButtonTh{
    display: flex;
    flex-wrap: wrap;
    gap: 12px;  
    max-width: 120px;
  }
}
</style>