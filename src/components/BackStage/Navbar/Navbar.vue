<template>
  <nav
    :class="{ active: isBackStageNavbarOpen }"
    ref="navbarRef"
  >
    <ul>
      <li class="close_li">
        <svg 
          @click="closeNavbar" 
          xmlns="http://www.w3.org/2000/svg" 
          height="32" width="24" 
          viewBox="0 0 384 512">
            <path fill="currentColor" d="M376.6 84.5c11.3-13.6 9.5-33.8-4.1-45.1s-33.8-9.5-45.1 4.1L192 206 56.6 43.5C45.3 29.9 25.1 28.1 11.5 39.4S-3.9 70.9 7.4 84.5L150.3 256 7.4 427.5c-11.3 13.6-9.5 33.8 4.1 45.1s33.8 9.5 45.1-4.1L192 306 327.4 468.5c11.3 13.6 31.5 15.4 45.1 4.1s15.4-31.5 4.1-45.1L233.7 256 376.6 84.5z"/>
        </svg>
      </li>
      <li>
        <router-link  
          :class="{ active: route.path.includes('Home') }"
          to="/BackStage/Home"
        >
          <svg 
            xmlns="http://www.w3.org/2000/svg" 
            viewBox="0 0 576 512"
            height="12" 
            width="13.5" 
          >
            <path fill="currentColor" d="M575.8 255.5c0 18-15 32.1-32 32.1l-32 0 .7 160.2c0 2.7-.2 5.4-.5 8.1l0 16.2c0 22.1-17.9 40-40 40l-16 0c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1L416 512l-24 0c-22.1 0-40-17.9-40-40l0-24 0-64c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32 14.3-32 32l0 64 0 24c0 22.1-17.9 40-40 40l-24 0-31.9 0c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2l-16 0c-22.1 0-40-17.9-40-40l0-112c0-.9 0-1.9 .1-2.8l0-69.7-32 0c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/>
          </svg>
          首頁
        </router-link>
      </li>
      <li
        v-for="(info, index) in navbarMainOption"
        :key="index"
      >
        <router-link 
          v-if="index === 0" 
          :class="{ active: route.path.includes('About') }"          
          to="/BackStage/About"
        >
          <svg 
            xmlns="http://www.w3.org/2000/svg" 
            viewBox="0 0 448 512"
            height="12" 
            width="10.5" 
          >
            <path fill="currentColor" d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z"/>
          </svg>
          {{ info.name }}
        </router-link>

        <router-link 
          v-if="index === 1" 
          :class="{ active: route.path.includes('Article') }"
          to="/BackStage/Article"
        >
          <svg 
            xmlns="http://www.w3.org/2000/svg" 
            height="12" 
            width="12" 
            viewBox="0 0 512 512"
          >
            <path fill="currentColor" d="M318.6 9.4c-12.5-12.5-32.8-12.5-45.3 0l-120 120c-12.5 12.5-12.5 32.8 0 45.3l16 16c12.5 12.5 32.8 12.5 45.3 0l4-4L325.4 293.4l-4 4c-12.5 12.5-12.5 32.8 0 45.3l16 16c12.5 12.5 32.8 12.5 45.3 0l120-120c12.5-12.5 12.5-32.8 0-45.3l-16-16c-12.5-12.5-32.8-12.5-45.3 0l-4 4L330.6 74.6l4-4c12.5-12.5 12.5-32.8 0-45.3l-16-16zm-152 288c-12.5-12.5-32.8-12.5-45.3 0l-112 112c-12.5 12.5-12.5 32.8 0 45.3l48 48c12.5 12.5 32.8 12.5 45.3 0l112-112c12.5-12.5 12.5-32.8 0-45.3l-1.4-1.4L272 285.3 226.7 240 168 298.7l-1.4-1.4z"/>
          </svg>
          {{ info.name }}
        </router-link>

        <router-link 
          v-if="index === 2" 
          :class="{ active: route.path.includes('Join') }"
          to="/BackStage/Join"
        >
          <svg 
            xmlns="http://www.w3.org/2000/svg" 
            height="16" 
            width="10" 
            viewBox="0 0 320 512"
          >
            <path fill="currentColor" d="M160 48a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zM126.5 199.3c-1 .4-1.9 .8-2.9 1.2l-8 3.5c-16.4 7.3-29 21.2-34.7 38.2l-2.6 7.8c-5.6 16.8-23.7 25.8-40.5 20.2s-25.8-23.7-20.2-40.5l2.6-7.8c11.4-34.1 36.6-61.9 69.4-76.5l8-3.5c20.8-9.2 43.3-14 66.1-14c44.6 0 84.8 26.8 101.9 67.9L281 232.7l21.4 10.7c15.8 7.9 22.2 27.1 14.3 42.9s-27.1 22.2-42.9 14.3L247 287.3c-10.3-5.2-18.4-13.8-22.8-24.5l-9.6-23-19.3 65.5 49.5 54c5.4 5.9 9.2 13 11.2 20.8l23 92.1c4.3 17.1-6.1 34.5-23.3 38.8s-34.5-6.1-38.8-23.3l-22-88.1-70.7-77.1c-14.8-16.1-20.3-38.6-14.7-59.7l16.9-63.5zM68.7 398l25-62.4c2.1 3 4.5 5.8 7 8.6l40.7 44.4-14.5 36.2c-2.4 6-6 11.5-10.6 16.1L54.6 502.6c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L68.7 398z"/>
          </svg>
          {{ info.name }}
        </router-link>

        <router-link 
          v-if="index === 3" 
          :class="{ active: route.path.includes('Contact') }"
          to="/BackStage/Contact"
        >
          <svg 
            xmlns="http://www.w3.org/2000/svg" 
            height="12" 
            width="12" 
            viewBox="0 0 512 512"
          >
            <path fill="currentColor" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"/>
          </svg>
          {{ info.name }}
        </router-link>
      </li>

      <!-- 店家管理 -->
      <div 
        
        class="storeInfo"
        :class="{ active: route.path.includes('BasicInfo') }"
      >
        <div class="storeInfoMain" @click="sidebarOptionTwoButton">
          <svg 
            xmlns="http://www.w3.org/2000/svg" 
            height="12" 
            width="12" 
            viewBox="0 0 512 512"
          >
            <path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336l24 0 0-64-24 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l48 0c13.3 0 24 10.7 24 24l0 88 8 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-80 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/>
          </svg>
          店家基本資訊
          <svg 
            class="angleSVG"
            :class="{active: isBackStageNavbarOptionTwoOpen}" 
            xmlns="http://www.w3.org/2000/svg" 
            height="16" width="12" 
            viewBox="0 0 320 512">
              <path fill="currentColor" d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/>
          </svg>
        </div>       
              <!-- 下拉選單部分 -->
        <div 
          class="sidebarOptionTwoDown"
          :class="{ active: isBackStageNavbarOptionTwoOpen }"
        >
          <div 
            class="sidebarOptionTwoDownLink"
            :class="{ active: route.path.includes('StoreInfo') }"
          >
            <router-link to="/BackStage/StoreInfo">店家資訊</router-link>
          </div>
          <div 
            class="sidebarOptionTwoDownLink"
            :class="{ active: route.path.includes('BasicInfo') }"
          >
            <router-link to="/BackStage/BasicInfo">網站設定</router-link>
          </div>
        </div>
      </div>

      <li>
        <router-link 
          :class="{ active: route.path.includes('UserData') }"
          to="/BackStage/UserData"
        >
          <svg 
            xmlns="http://www.w3.org/2000/svg" 
            height="12" 
            width="10.5" 
            viewBox="0 0 448 512"
          >
            <path fill="currentColor" d="M448 80l0 48c0 44.2-100.3 80-224 80S0 172.2 0 128L0 80C0 35.8 100.3 0 224 0S448 35.8 448 80zM393.2 214.7c20.8-7.4 39.9-16.9 54.8-28.6L448 288c0 44.2-100.3 80-224 80S0 332.2 0 288L0 186.1c14.9 11.8 34 21.2 54.8 28.6C99.7 230.7 159.5 240 224 240s124.3-9.3 169.2-25.3zM0 346.1c14.9 11.8 34 21.2 54.8 28.6C99.7 390.7 159.5 400 224 400s124.3-9.3 169.2-25.3c20.8-7.4 39.9-16.9 54.8-28.6l0 85.9c0 44.2-100.3 80-224 80S0 476.2 0 432l0-85.9z"/>
          </svg>
            後台管理
        </router-link>
      </li>

      <li>
        <div 
          class="a"
          @click="logout"
          >
          <svg 
            xmlns="http://www.w3.org/2000/svg" 
            height="12" 
            width="12" 
            viewBox="0 0 512 512"
          >
            <path fill="currentColor" d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/>
          </svg>
          登出
        </div>
      </li>
    </ul>
  </nav>
</template>

<script>
import { computed, onMounted, onUnmounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useStore } from 'vuex';

export default {
  props:{
    navbarMainOption:{
      type:     Array,
      default:  () => {}
    }
  },
  setup() {
    const router = useRouter();
    const route = useRoute();
    const store = useStore();
    const isBackStageNavbarOpen = computed(()=>
      store.getters['NavbarStore/getBackStageNavbar']
    );
    const isBackStageNavbarOptionTwoOpen = computed(()=>
      store.getters['NavbarStore/getBackStageNavbarOptionTwo']
    );
    const closeNavbar = () => {
      store.dispatch('NavbarStore/closeBackStageNavbar')
    }
    const closeOptionTwo = () => {
      store.dispatch('NavbarStore/closeBackStageNavbarOptionTwo')
    }
    const sidebarOptionTwoButton = ()=>{
      store.dispatch('NavbarStore/toggleBackStageNavbarOptionTwo')
    };

    const logout = () =>{
      document.cookie = "sessionId=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC"; // 移除 Cookie      
      router.push('/Login');
    }

    //處理1024px以下navbar
    onMounted(() => {
      document.addEventListener('click', handleClickOutside);
      document.addEventListener('registerBurgerRef', (event) => {
        burgerButtonElement.value = event.detail.el;
      });
      document.addEventListener('click', handleSidebarOptionTwoDowDisplay);
    });
    onUnmounted(() => {
      document.removeEventListener('click', handleClickOutside);
      document.removeEventListener('click', handleSidebarOptionTwoDowDisplay);
    });

    //如果點到navbar以外地方也會觸發關起
    const navbarRef = ref(null);
    const burgerButtonElement = ref(null);

    const handleClickOutside = (event) => {
      const navbarElement = navbarRef.value;
      const burgerButton = burgerButtonElement.value;

      if (!navbarElement) return;

      const clickedInsideNavbar = navbarElement.contains(event.target);
      const clickedBurgerButton = burgerButton?.contains(event.target);
      const isRouterLink = event.target.closest('a');

      if (!clickedInsideNavbar && !clickedBurgerButton || isRouterLink) {
        closeNavbar();
      }
    };

    //處理下拉顯示
    const handleSidebarOptionTwoDowDisplay = (event) =>{
      const isRouterLink = event.target.closest('a'); 
      if(isRouterLink){
        const href = isRouterLink.getAttribute('href');
        if(href.includes('/StoreInfo') || href.includes('/BasicInfo')){
          return;
        }
        closeOptionTwo();
      }
    }

    return{
      logout,
      route,
      navbarRef,
      isBackStageNavbarOptionTwoOpen,
      sidebarOptionTwoButton,
      isBackStageNavbarOpen,
      closeNavbar,
    }
  }
}
</script>

<style lang="scss" scoped>
nav{
  display: flex;
  flex-direction: column;
  height: 100vh;
  width: 240px;
  position: fixed;
  background-color: rgba($color: #000000, $alpha: 0.6);
  color: white;

  ul{
    .close_li{
      display: none;
      height: 64px;
      align-items: center;
      justify-content: right;
      svg{
        padding: 12px;
        margin-right: 12px;
        cursor: pointer;
      }
    }
    // 下拉選單設定
    .storeInfo{
      display: flex;
      flex-direction: column;

      .storeInfoMain{
        display: flex;
        width: auto;
        font-size: 16px;
        padding: 12px 0;
        padding-left: 48px;
        align-items: center;
        column-gap: 12px;
        cursor: pointer;

        .angleSVG{
          padding: 0;
          transition: transform 0.3s ease-in-out; /* 動畫過渡效果 */
        }
        .angleSVG.active{
          transform: rotate(270deg); /* 當展開時，旋轉 180 度 */
        }
      }
      .sidebarOptionTwoDown{
        display: flex;          
        flex-direction: column;
        width: 100%;
        overflow: hidden;
        max-height: 0; /* 隱藏狀態 */
        opacity: 0; /* 隱藏狀態 */
        transition: max-height 0.3s ease, opacity 0.3s ease; /* 添加動畫過渡 */
        background-color: rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(10px);
        padding: 0;
         
        .sidebarOptionTwoDownLink{
          a{
            display: flex;
            width: auto;
            font-size: 16px;
            padding: 12px 0;
            padding-left: 76px;
            align-items: center;
            column-gap: 12px;
            cursor: pointer;
          }
          a:hover{
            color: white;
          }         
        }
        .sidebarOptionTwoDownLink:hover{
          background-color: rgba(0, 0, 0, 0.2);
        }
        .active{
          background-color: rgba(0, 0, 0, 0.4);
        }        
      }
      .sidebarOptionTwoDown.active {
        max-height: 100%; /* 動畫過渡到最大高度 */
        opacity: 1; /* 完全顯示 */
      }
    }
    .storeInfo:hover{
      background-color: rgba(0, 0, 0, 0.2);
      transition: 0.3s;
    }
    .active .storeInfoMain:hover {
      background-color: rgba(0, 0, 0, 0.2);
      transition: 0.3s;
    }
    li{
      a,
      .a{
        display: flex;
        width: auto;
        font-size: 16px;
        padding: 12px 0;
        padding-left: 48px;
        align-items: center;
        column-gap: 12px;
        cursor: pointer;
      }
      a:hover,
      .a:hover{
        background-color: rgba(0, 0, 0, 0.2);
        transition: 0.3s;
      }
      .active{
        background-color: rgba(0, 0, 0, 0.4);
      }
      .active:hover {
        background-color: rgba(0, 0, 0, 0.2);
        transition: 0.3s;
      }
    }
  }
}
@media (max-width: 1024px) {
  nav{
    position: fixed;
    left: 0;
    backdrop-filter: blur(10px);
    box-shadow: 10px 0 10px rgba(0, 0, 0, 0.1);
    transform: translateX(-100%);
    transition: transform 0.3s ease-in-out;
    overflow-y: auto;
    z-index: 999;

    &.active {
      transform: translateX(0); /* 顯示在畫面內 */
    }    
    ul{
      .close_li{
        display: flex;
      }
      li{
        a,.a{
          font-size: 18px;
        }
      }
      .storeInfo{
        .sidebarOptionTwoDown{
          background-color: rgba(92, 92, 92, 0.7);
        }
      }
    }
  }  
}
@media (max-width: 768px) {
  nav{
    width: 100%;

    ul{
      li{
        a,.a{
          width: 100%;
          padding: 24px 0;
          justify-content: center;
        }
      }
      .storeInfo{
        .storeInfoMain{
          padding: 24px 0;
          width: 100%;
          justify-content: center;

          .angleSVG{
            display: none;
          }
        }
        .sidebarOptionTwoDown{          
          .sidebarOptionTwoDownLink{
            justify-items: center;
            
            a{
              width: 100%;
              padding: 24px 0;
              justify-content: center;
            }
          }
        }
      }
    }
  }  
}
</style>