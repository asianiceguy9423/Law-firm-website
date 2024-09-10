<template>
  <div>
    <nav>
      <router-link to="/" >
        <img :src="currentImageUrl">
      </router-link>
      
      <ul class="navbar">
        <router-link to="/About">
          <li>關於昭翰</li>
        </router-link>

        <li class="LowdLiHoverContainer">
          <div class="LowdLiHover">
            <div>法律資訊</div>
          </div>
          <div class="dropDown">
            <router-link to="/Patent">
              <div  class="dropDownBox">智慧財產權</div>
            </router-link>            
            <router-link to="/Transportation">
              <div class="dropDownBox">車禍</div>
            </router-link>
            <router-link to="/Labor">
              <div  class="dropDownBox">勞資糾紛</div>
            </router-link>
            <router-link to="/Civil">
              <div  class="dropDownBox">民事案件</div>
            </router-link>
            <router-link to="/Criminal">
              <div  class="dropDownBox">刑事案件/毒品犯罪</div>
            </router-link>
          </div>
        </li>
        
        <router-link to="/Join">
          <li>加入老周</li>
        </router-link>
        
        <router-link to="/Connection">
          <li>聯絡我們</li>
        </router-link>   
      </ul>
      
      <font-awesome-icon class="burgerMark" :icon="['fas', 'bars']" size="2xl" style="color: #ffff;" @click="BurgerButtonClick" v-show="BurgerButtonShow"/>
    </nav>

    <div class="sidebar" v-show="SidebarShow">
      <font-awesome-icon :icon="['fas', 'x']" size="2xl" style="color: #ffff;" @click="BurgerButtonClick"
      class="XMark"/>
      <router-link to="/About">
          <li @click="BurgerButtonClick">
            <span class="spanLink">關於昭翰</span>
          </li>
        </router-link>

          <li @click="clickSidebarLaw" class="LawLiSidbar">
            <span class="spanLink">法律資訊</span>
            <span :class="['angleMark', rotateAngleMark]">
              <font-awesome-icon :icon="['fas', 'angle-right']" />
            </span>
          </li>
          <div v-if="sidebarLawShow" class="LawDiv">
            <router-link to="/Patent">
              <div class="LawChoose">智慧財產權</div>
            </router-link>
            <router-link to="/Transportation">
              <div class="LawChoose">車禍</div>
            </router-link>
            <router-link to="/Labor">
              <div class="LawChoose">勞資糾紛</div>
            </router-link>
            <router-link to="/Civil">
              <div class="LawChoose">民事案件</div>
            </router-link>
            <router-link to="/Criminal">
              <div class="LawChoose">刑事案件/毒品犯罪</div>
            </router-link>
          </div>
          
        <router-link to="/Join">
          <li>
            <span class="spanLink">加入老周</span>
          </li>
        </router-link>
        <router-link to="/Connection">
          <li>
            <span class="spanLink">聯絡我們</span>
          </li>
        </router-link>
    </div>
  </div>
</template>

<script>
  import axios from 'axios';
  export default {
    data(){
      return{
        SidebarShow:false,
        BurgerButtonShow:true,
        currentLOGO: '',
        sidebarLawShow:false,
        isSmallScreen: false,
      }
    },
    computed: {
      currentImageUrl() {
        return `${this.$apiurl}/src/assets/basic/${this.currentLOGO}`;
      },
      rotateAngleMark(){
        return this.sidebarLawShow ? 'rotate' : '';
      },
    },
    created() {
    this.fetchDetails();
    },
    mounted(){
      document.addEventListener('click', this.handleOutSideClick);
    },
    beforeDestroy(){
      document.removeEventListener('click', this.handleOutSideClick);
    },
    methods:{
      clickSidebarLaw(){
        this.sidebarLawShow =! this.sidebarLawShow;
      },
      BurgerButtonClick(event){
        event.stopPropagation();
        this.SidebarShow= !this.SidebarShow,
        this.BurgerButtonShow= !this.BurgerButtonShow
      },
      fetchDetails() {
        axios.get(`${this.$apiurl}/api/FetchBasicPage.php`)
        .then(response => {
          const data = response.data;
          if (data.success) {
            const basic = data.basic;
            this.currentLOGO = basic.basic_logo;
          }
        })
        .catch(error => {
          console.error(error);
        })
      },
      handleOutSideClick(event){
        const sidebar = this.$el.querySelector('.sidebar');
        const burgerMark = this.$el.querySelector('.burgerMark');
        const LawDiv = this.$el.querySelector('LawDiv');
        if(this.SidebarShow && sidebar && !sidebar.contains(event.target) && !burgerMark.contains(event.target)){
          this.SidebarShow = false;
          this.BurgerButtonShow = true;
        }
        if(this.SidebarShow && this.LawDiv && !LawDiv.contains(event.target)){
          this.SidebarShow = false;
        }
      }
    }
  }
</script>

<style scoped>
nav{
  display: flex;
  align-items: center;
  height: 100px;
  width: 100%;
  justify-content: space-between;
  position: fixed;
  background-color: rgba(0, 0, 0, 0.6);
  box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.1);
  z-index: 100;
}
ul{
  display: flex;
  text-align: center;
  padding: 0 20px;
}
li{
  height: 100px;
  box-sizing: border-box;
  align-content: center;
  padding: 20px 40px;
  color: #fff;
}
li:hover{
  cursor: pointer;
  color: rgb(214, 185, 105); 
  transition: 0.4s;
}
.burgerMark{
  margin-right: 50px;
  display: none;
}
svg:hover{
  cursor: pointer;
}
img{
  height: 30px;
  padding: 0 40px;
}
.XMark{
  margin-left: 30px;
  position: fixed;
  top: 35px;
}
.LowdLiHoverContainer{
  position: relative;
}
.LowdLiHover{   
  color: #fff;
}
.LowdLiHoverContainer:hover .LowdLiHover,
.LowdLiHoverContainer:hover .dropDown{
  cursor: pointer;
  color: rgb(214, 185, 105); 
  transition: 0.4s;
}
.dropDown{
  background-color: rgba(0, 0, 0, 0.6);
  box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.1);
  position: absolute;
  z-index: 999;
  top: 100%;
  left: 0;
  display: none;
}
.LowdLiHoverContainer:hover .dropDown{
  display: block;
}
.dropDownBox{
  padding: 20px 16px;
  justify-content: center;
  border-bottom: 0.5px solid rgba(255, 255, 255, 0.3);
  color: #fff;
  transition: background-color 0.3s, color 0.3s;
}
.dropDownBox:hover{
  background-color: rgba(214, 185, 105, 0.8);
  color: #000;
  cursor: pointer;
}
.sidebar{
  display: none;
}

@media(max-width: 1250px){
  .burgerMark{
    display: inline-block;
  }
  .navbar{
    display: none;
  }
  .sidebar{
    display: inline-block;
    z-index: 999;
    position: fixed;
    right: 0;
    height: 100vh;
    width: 250px;
    padding-top: 100px;
    align-items: center;
    background-color: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(10px);
    box-shadow: -10px 0 10px rgba(0, 0, 0, 0.1);
  }
  .LawLiSidbar{
    justify-content: space-between;
  }
  .LawDiv{
    color: #fff;
    background-color: rgba(0, 0, 0, 0.6);
    font-size: 14px;
    font-weight: 300;
  }
  .LawChoose{
    padding: 12px 24px;
    border-bottom: solid 1px rgba(214, 185, 105, 0.3);
    transition: 0.3s;
  }
  .LawChoose:hover{
    background-color: rgba(214, 185, 105, 0.8);
    color: #000;
    font-weight: 500;
    cursor: pointer;
  }
  .angleMark {
    transition: transform 0.5s;
  }
  .rotate {
    transform: rotate(-90deg);
  }
  li{
    padding: 0;
    height: auto;
    display: flex;
    align-items: center;
    border-top: solid 1px #fff;
  }
  .angleMark,
  .spanLink{
    padding: 20px 16px;
  }
  @media(max-width: 300px){
    .sidebar{
      width: 100%;
    }
  }
}
</style>