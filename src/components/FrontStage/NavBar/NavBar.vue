<template>
  <div
  :style="styleVars">
    <nav>
      <router-link to="/">
        <img v-lazy="currentLOGO" alt="LOGO">
      </router-link>
      
      <ul>
        <li 
          v-for="(info, index) in filteredNavbarInfo" 
          :key="index"
          :class="{ 'navbarOptionTwo': index === 1 }"
        >
        <component 
          :is="getNavComponent(index)"
          :to="getNavLink(index)"
        >
           {{ info.name }}
        </component>      

          <!-- 下拉選單部分 -->
          <div
            v-if="index === 1"
            class="navbarOptionTwoDown"
          >
            <li>
              <router-link
                v-for="(option, index) in filterednavbarOptionsInfo" 
                :key="index"
                :to="`/Articles/${option.number}`"
              >
                {{ option.name }}
              </router-link>
            </li>
          </div>
        </li>
      </ul>
      <svg 
      @click="BurgerButton" 
      ref="burgerButtonRef" 
      xmlns="http://www.w3.org/2000/svg" 
      height="32" width="28" 
      viewBox="0 0 448 512">
        <path  fill="currentColor" d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"/>
    </svg>
    </nav>

    <nav 
    v-show="true"
    class="sidebar"
    :class="{ active: sideBarDisplay }"
    ref="sidebarRef"
    >
      <svg 
      @click="BurgerButton" 
      xmlns="http://www.w3.org/2000/svg" 
      height="32" width="24" 
      viewBox="0 0 384 512">
        <path fill="currentColor" d="M376.6 84.5c11.3-13.6 9.5-33.8-4.1-45.1s-33.8-9.5-45.1 4.1L192 206 56.6 43.5C45.3 29.9 25.1 28.1 11.5 39.4S-3.9 70.9 7.4 84.5L150.3 256 7.4 427.5c-11.3 13.6-9.5 33.8 4.1 45.1s33.8 9.5 45.1-4.1L192 306 327.4 468.5c11.3 13.6 31.5 15.4 45.1 4.1s15.4-31.5 4.1-45.1L233.7 256 376.6 84.5z"/>
    </svg>
    <!-- sidebar部分 -->
      <ul>
        <li
          v-for="(info, index) in filteredNavbarInfo"
          :key="index"
          :class="{ 'navbarOptionTwo': index === 1 }"
        >
          <router-link v-if="index === 0" to="/About">
            {{ info.name }}
          </router-link>

          <div 
            v-if="index === 1"
            @click="sidebarOptionTwoButton"
          >
            {{ info.name }}
            <svg 
              :class="{active: sidebarOptionTwoDownDisplay}" 
              xmlns="http://www.w3.org/2000/svg" 
              height="20" width="12" 
              viewBox="0 0 320 512">
                <path fill="currentColor" d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/>
            </svg>
          </div>

          <router-link v-if="index === 2" to="/Join">
            {{ info.name }}
          </router-link>

          <router-link v-if="index === 3" to="/Contact">
            {{ info.name }}
          </router-link>

          <!-- 下拉選單部分 -->
          <div 
            v-if="index === 1"
            class="sidebarOptionTwoDown" 
            :class="{ active: sidebarOptionTwoDownDisplay }"
          >
            <div v-for="(option, index) in filterednavbarOptionsInfo" :key="index">
              <router-link :to="`/Articles/${option.number}`">
                {{ option.name }}
              </router-link>              
            </div>
          </div>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
import { computedStyleVars, getIMGUrl } from '@/utils/tools';
import { computed, inject, onMounted, onUnmounted, ref } from 'vue';
import { useStore } from 'vuex';

export default {
  setup() {
    const store   = useStore();
    const apiUrl  = inject('apiUrl');

const getNavComponent = (index) => {
  return index === 1 ? 'div' : 'router-link';
};

const getNavLink = (index) => {
  if (index === 0) return '/About';
  if (index === 2) return '/Join';
  if (index === 3) return '/Contact';
  return '';
};

    //獲取vuex
    onMounted(() =>{
      store.dispatch('WebsiteInformation/fetchDetails');
      document.addEventListener('click', handleClickOutside);
    });

    onUnmounted(() => {
      document.removeEventListener('click', handleClickOutside);
    });  

    const websiteInfo = computed(() => store.getters['WebsiteInformation/getWebsiteInformations']);

    //LOGO獲取
    const currentLOGO = computed(() =>
    getIMGUrl(apiUrl, 'basic', websiteInfo.value.currentLOGO)
    );

    //mainNavbar處理
    const filteredNavbarInfo = computed(()=>
      websiteInfo.value.navbarMainOption.filter((info) => info.display)
    );

    //navbarOptions處理
    const filterednavbarOptionsInfo = computed(()=>
      websiteInfo.value.navbarOptions.filter((option) => option.display)
    );

    //處理sidebar
    const sideBarDisplay = ref(false);
    const BurgerButton = ()=>{
      sideBarDisplay.value =! sideBarDisplay.value;
    };

    //處理angle旋轉及分頁顯示
    const sidebarOptionTwoDownDisplay = ref(false);
    const sidebarOptionTwoButton = ()=>{
      sidebarOptionTwoDownDisplay.value =! sidebarOptionTwoDownDisplay.value;
    };

    //如果點到sidebar以外地方也會觸發關起sidebar
    const sidebarRef = ref(null);
    const burgerButtonRef = ref(null);    

    const handleClickOutside = (event) => {
      const sidebarElement = sidebarRef.value;
      const burgerButtonElement = burgerButtonRef.value;
      const isRouterLink = event.target.closest('a'); 
      const clickOutsideSidebar  = 
        sidebarElement && 
        !sidebarElement.contains(event.target) &&
        burgerButtonElement && 
        !burgerButtonElement.contains(event.target);

      if (clickOutsideSidebar || isRouterLink) {
        sideBarDisplay.value = false;
        sidebarOptionTwoDownDisplay.value = false;
      }
    };

    const styleVars = computedStyleVars();

    return {
      currentLOGO,
      websiteInfo,
      sideBarDisplay,
      BurgerButton,
      sidebarOptionTwoDownDisplay,
      sidebarOptionTwoButton,
      sidebarRef,
      burgerButtonRef,
      filteredNavbarInfo,
      filterednavbarOptionsInfo,
      styleVars,
      getNavComponent,
      getNavLink,
    }
  }
}
</script>

<style lang="scss" scoped>
nav{
  display: flex;
  align-items: center;
  height: 100px;
  width: 100%;
  justify-content: space-between;
  position: fixed;
  background-color: rgba(var(--fourth-color-rgb), 0.6);
  box-shadow: 3px 3px 5px rgba(var(--fourth-color-rgb), 0.1);
  z-index: 100;

  a{
    display: flex;
    height: 100%;
    padding: 30px 40px;
      box-sizing: border-box;
    img{
      object-fit: cover;      
    }
  }
  ul{
    display: flex;
    column-gap: 4px;
    height: 100%;
    text-align: center;
    padding: 0 20px;

    li{
      display: flex;
      box-sizing: border-box;
      align-content: center;
      color: rgb(var(--secondary-color-rgb));

      a,div{
        display: flex;
        align-items: center;
        justify-items: center;
        padding: 0 40px;
        font-size: 18px;
        color: rgb(var(--secondary-color-rgb));
        height: 100%;
        width: 100%;
      }
      a:hover,div:hover{
        cursor: pointer;
        color: rgb(var(--main-color-rgb)); 
        transition: 0.4s;
      }
    }
    .navbarOptionTwo{
      position: relative;
      display: flex;
      flex-direction: row;
      align-items: center;
      padding: 0;

      .navbarOptionTwoDown{
        position: absolute;
        display: none;
        top: 100px;
        left: 0;
        width: 100%;
        height: auto;
        flex-direction: column;
        background-color: rgba(var(--fourth-color-rgb), 0.6);
        padding: 0;
        z-index: 999;

        li{
          display: flex;
          width: 100%;
          flex-direction: column;

          a{
            padding: 20px 20px;
            justify-content: center;
            border-top: solid 1px rgba(var(--secondary-color-rgb),0.3);
          }
          a:hover{
            background-color: rgba(var(--main-color-rgb), 0.8);
            color: #000;
            font-weight: 600;
          }
        }
      }
      &:hover .navbarOptionTwoDown {
        display: flex;
      }
    }
  }
  svg{
    color: rgb(var(--secondary-color-rgb));
    padding-right: 40px;
    display: none;
  }
}
.sidebar{
  display: none;
}

@media (max-width: 1024px) {
  nav{
    ul{
      display: none;
    }
    svg{
      display: inline-block;
      cursor: pointer;
    }
  }

  .sidebar{
    display: inline-block;
    position: fixed;
    right: 0;
    height: 100vh;
    width: 250px;
    background-color: rgba(var(--fourth-color-rgb), 0.6);
    backdrop-filter: blur(10px);
    box-shadow: -10px 0 10px rgba(var(--fourth-color-rgb), 0.1);
    transform: translateX(100%); /* 初始在畫面右側外 */
    transition: transform 0.3s ease-in-out; /* 過渡動畫 */
    overflow-y: auto /* 讓下拉選單也可滾動 */;
    z-index: 999;

    &.active {
      transform: translateX(0); /* 顯示在畫面內 */
    }

    svg{
      color: rgb(var(--secondary-color-rgb));
      padding: 24px;
      margin: 0;
    }

    ul{
      display: flex;
      flex-direction: column;
      padding: 0;

      li{
        display: flex;
        height: auto;
        align-items: center;
        border-top: solid 1px rgb(var(--secondary-color-rgb));

        a{
          padding: 20px 16px;
        }
      }
      .navbarOptionTwo{
        display: flex;
        flex-direction: column;
        
        div{
          padding: 20px 16px;
          display: flex;
          height: auto;
          justify-content: space-between;
          box-sizing: border-box;

          svg{
            padding: 0;
            transition: transform 0.3s ease-in-out; /* 動畫過渡效果 */
          }
          svg.active{
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
          background-color: rgba(var(--fourth-color-rgb), 0.6);
          backdrop-filter: blur(10px);
          padding: 0;

          div{
            padding: 0;
            width: 100%;
            font-weight: 300;
            height: auto;
            a{
              border-bottom: solid 1px rgba(214, 185, 105, 0.3);
            }
            a:hover{
              background-color: rgb(var(--main-color-rgb));
              color: #000;
              font-weight: 600;
            }
          }
        }
        .sidebarOptionTwoDown.active {
          max-height: 100%; /* 動畫過渡到最大高度 */
          opacity: 1; /* 完全顯示 */
        }
      }
    }
    .navbarOptionTwo:hover svg{
      cursor: pointer;
      color: rgb(var(--main-color-rgb));
      transition: 0.4s;
    }
  }
}
@media (max-width: 768px) {
  nav{
    a{
    padding: 30px 24px;
  }

    svg{
      padding-right: 24px;
    }
  }  
}
</style>