<template>
  <div>
    <nav>
        <ul>
          <router-link 
            :class="{ active: selectedItem.includes('home') }" @click.native="selectItem('home')"
            to="/BackStage/HomePage"
            class="li-router">
            <span class="IconSpan">
              <font-awesome-icon :icon="['fas', 'house']" size="xs" />
            </span>
            首頁
          </router-link>

          <li :class="{active: selectedItem.includes('about')}" 
          @click="aboutHandler"
          class="li-router">
            <span class="IconSpan">
              <font-awesome-icon :icon="['fas', 'user']"  size="xs" />
            </span>
            <div>關於昭翰</div>          
            <span :class="rotateClass"  class="IconSpan IconSpanPoint">
              <font-awesome-icon :icon="['fas', 'angle-right']" />
            </span>
          </li>
          <div v-if="AboutShow">
            <router-link
              to="/BackStage/AboutPage"
              class="full-link"
              :class="{ active: selectedItem.includes('aboutOne') }"
              @click.native="selectItem('aboutOne')"
            >&nbsp;About1
          </router-link>
          <router-link
              to="/BackStage/AbouPageTwo"
              class="full-link"
              :class="{ active: selectedItem.includes('aboutTwo') }"
              @click.native="selectItem('aboutTwo')"
            >&nbsp;About2
          </router-link>
          <router-link
              to="/BackStage/AbouPageThreeRouter"
              class="full-link"
              :class="{ active: selectedItem.includes('aboutThree') }"
              @click.native="selectItem('aboutThree')"
            >&nbsp;About3
          </router-link>        
          </div>

          <router-link 
            :class="{ active: selectedItem.includes('legal') }" @click.native="selectItem('legal')"
            to="/BackStage/LawPage"
            class="li-router"
          >
            <span class="IconSpan">
              <font-awesome-icon :icon="['fas', 'gavel']"  size="xs"/>
            </span>          
            法律資訊
          </router-link>

          <router-link 
            :class="{ active: selectedItem.includes('join') }" @click.native="selectItem('join')"
            to="/BackStage/JoinPage"
            class="li-router"
            >
            <span class="IconSpan">
              <font-awesome-icon :icon="['fas', 'person-walking']" />
            </span>          
            加入老周
          </router-link>

          <router-link 
            :class="{ active: selectedItem.includes('contact')}" @click.native="selectItem('contact')"
            to="/BackStage/ContactPage"
            class="li-router"
            >
            <span class="IconSpan">
              <font-awesome-icon :icon="['fas', 'phone']"  size="xs"/>
            </span>聯絡我們
          </router-link>

          <router-link 
            :class="{ active: selectedItem.includes('userdata')}" @click.native="selectItem('userdata')"
            to="/BackStage/UserData"
            class="li-router"
            >
            <span class="IconSpan">
              <font-awesome-icon :icon="['fas', 'database']"  size="xs"/>
            </span>後台管理
          </router-link>

          <div @click="logout" class="li-router">
            <span class="IconSpan">
              <font-awesome-icon :icon="['fas', 'right-from-bracket']"  size="xs"/></span>
              登出
          </div>        
        </ul>
      </nav>
  </div>
</template>

<script>
import axios from 'axios';
import Cookies from 'js-cookie';
export default {
  name: 'NavBar',
  data() {
    return {
      selectedItem: ['home'],
      AboutShow: false,
      AngleC: false,
    };
  },
  computed: {
    rotateClass() {
      return this.selectedItem.some(item =>  item.includes('about')) ? 'rotate' : '';
    },
  },
  methods: {
    selectItem(item) {
        this.selectedItem = [item];
      if (this.AheckAboutFamily()) {
        this.AboutShow = false;
      } else {
        this.AboutShow = true;
      }
    },
    aboutHandler() {
      if (this.selectedItem.some(item =>  item.includes('about'))) {
        this.selectedItem = [];
        this.AboutShow = false;
      } else {
        this.selectItem('about');
        this.AboutShow = true;
      }
    },
    AheckAboutFamily() {
      return !this.selectedItem.some(item =>  item.includes('about'));
    },
    logout(){
      axios.post(`${this.$apiurl}/api/Logout.php`)
      .then(() =>{
          Cookies.remove('sessionId');
          this.$router.push('LoginPage');
      })
    }
  }
}
</script>

<style scoped>
nav{
  position: fixed;
  display: flex;
  flex-direction: column;
  height: 100vh;
  width: 250px;
  background-color: rgba(0, 0, 0, 0.6);
  color: white;
}
.li-router{
  display: flex;
  align-items: center;
  width: 200px;
  padding: 8px 0;
  padding-left: 50px;
  position: relative;
}
li{
  padding: 15px 0;
  padding-left: 50px;
}
li:hover,
.li-router:hover,
.full-link:hover{
  cursor: pointer;
  color: rgb(214, 185, 105);
  transition: 0.4s;
  background-color: rgba(0, 0, 0, 0.2);
}
.full-link{
  padding: 15px 0;
  padding-left: 65px;
  font-size: 14px;
  display: flex;
  background-color: rgba(0, 0, 0, 0.4);
}
.active {
  color: rgb(214, 185, 105);
  background-color: rgba(0, 0, 0, 0.4);
}
.active:hover {
  background-color: rgba(0, 0, 0, 0.4);
}
.IconSpan{
  margin-bottom: 9px;
  margin-right: 12px;
  margin-top: 9px;
  transition: transform 0.5s;
}
.IconSpanPoint{
  margin-top: 12px;
  float: right;
  position: absolute;
  right: 0;
}
.rotate {
  transform: rotate(-90deg);
}
@media(max-width: 1250px){
nav{
  display: none;
}
}

</style>